<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ModelsService
{
    public function alphaOrder($request, $letter = '')
    {
        $users = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos', 'model_info_love', 'portfolio'])
            ->where('name', 'like', $letter . '%')
            ->where('email', '!=', 'admin@admin.com')
            ->orderBy('name');

        if (isset($request['save_filter'])) {
            $queryString = $request['save_filter'];
            $queryArray = [];
            parse_str($queryString, $queryArray);
        }

        if (isset($queryArray['gender'])) {
            $users->whereIn('gender', $queryArray['gender']);
        }
        if (isset($queryArray['civil'])) {
            $users->whereIn('civil', $queryArray['civil']);
        }
        if (isset($queryArray['age_from'])) {
            $users->whereBetween('users.preferences->_age', [$queryArray['age_from'], $queryArray['age_to']]);
        }
        if (isset($queryArray['h_from'])) {
            $users->whereBetween(DB::raw("CAST(json_extract(`users`.`preferences`, '$._height') AS UNSIGNED)"), [$queryArray['h_from'], $queryArray['h_to']]);
        }
        if (isset($queryArray['_skin'])) {
            $users->where('users.preferences->_skin', $queryArray['_skin']);
        }
        if (isset($queryArray['dress'])) {
            $users->where('users.preferences->dress', $queryArray['dress']);
        }
        if (isset($queryArray['hair'])) {
            $users->where('users.preferences->hair', $queryArray['hair']);
        }
        if (isset($queryArray['eyes'])) {
            $users->where('users.preferences->eyes', $queryArray['eyes']);
        }
        // end save filter -----------------

        if (isset($request['filter_one'])) {
            $users->where('subscribed', $request['filter_one']);
        }
        if (isset($request['filter_two'])) {
            $users->where('status', $request['filter_two']);
        }
        if (isset($request['state'])) {
            $users->where('state', $request['state']);
        }
        if (isset($request['city'])) {
            $users->whereIn('city', $request['city']);
        }
        if (isset($request['keyword']) && $request['keyword'] != '') {
            $users->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $request['keyword'] . '%')
                    ->orWhere('wp', 'like', '%' . $request['keyword'] . '%');
            });
        }

        $users = $users->paginate(1);

        if(count($users) === 0) {
            return [];
        }

        $nextPageUrl = $users->nextPageUrl();
        $prevPageUrl = $users->previousPageUrl();

        $data = $users->map(function ($user) use ($nextPageUrl, $prevPageUrl) {
            $infos = [];
            $portfolios = [];

            if (isset($user->modelInfos) && count($user->modelInfos) > 0) {
                $infos = collect($user->modelInfos)->map(function ($info) {
                    return [
                        'rating' => $info['key'] == 'rate' ? max(0, $info['value']) : '',
                    ];
                });
            } else {
                $infos = collect([
                    ['rating' => 0],
                ]);
            }

            if (isset($user->portfolios)) {
                $portfolios = collect($user->portfolios)->map(function ($info) {
                    return [
                        'file_name' => $info['file_name'],
                        'ext' => $info['ext'],
                    ];
                });
            }

            $interest = $user->interest['content'] ?? 'No interest found for this model.';

            return [
                'uid' => $user->id,
                'user_status' => $user->status,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'city' => $user->city,
                'state' => $user->state,
                'civil' => $user->civil,
                'wp' => $user->wp,
                'love' => $user->model_info_love['value'] ?? '',
                'portfolio' => [
                    'file_name' => $user->portfolio['file_name'],
                    'ext' => $user->portfolio['ext'],
                ],
                'portfolioWithContestPhoto' => [
                    'file_name' => $user->portfolioWithContestPhoto['file_name'],
                    'ext' => $user->portfolioWithContestPhoto['ext'],
                ],
                'portfolios' => $portfolios,
                'infos' => $infos,
                'interest' => $interest,
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl,
            ];
        });

        return $data;
    }

    public function modelInfo(int $id)
    {
        $users = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos', 'model_info_love'])
            ->paginate(1);

        $nextPageUrl = $users->nextPageUrl();
        $prevPageUrl = $users->previousPageUrl();

        $data = $users->map(function ($user) use ($nextPageUrl, $prevPageUrl) {
            $infos = [];
            $portfolios = [];

            if (isset($user->modelInfos) && count($user->modelInfos) > 0) {
                $infos = collect($user->modelInfos)->map(function ($info) {
                    return [
                        'rating' => $info['key'] == 'rate' ? max(0, $info['value']) : '',
                    ];
                });
            } else {
                $infos = collect([
                    ['rating' => 0],
                ]);
            }

            if (isset($user->portfolios)) {
                $portfolios = collect($user->portfolios)->map(function ($info) {
                    return [
                        'file_name' => $info['file_name'],
                        'ext' => $info['ext'],
                    ];
                });
            }

            $interest = $user->interest['content'] ?? 'No interest found for this model.';

            return [
                'uid' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'city' => $user->city,
                'state' => $user->state,
                'civil' => $user->civil,
                'wp' => $user->wp,
                'love' => $user->model_info_love['value'] ?? '',
                'portfolioWithContestPhoto' => [
                    'file_name' => $user->portfolioWithContestPhoto['file_name'],
                    'ext' => $user->portfolioWithContestPhoto['ext'],
                ],
                'portfolios' => $portfolios,
                'infos' => $infos,
                'interest' => $interest,
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl,
            ];
        });

        return $data;
    }
}

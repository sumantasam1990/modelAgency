<?php

namespace App\Services;

use App\Models\User;

class ModelsService
{
    public function alphaOrder($request, $letter = '')
    {
//        $query = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos', 'model_info_love', 'portfolio'])
//            ->where('name', 'like', $letter . '%')
//            ->where('email', '!=', 'admin@admin.com')
//            ->orderBy('name');
//
//        if (isset($request['gender'])) {
//            $query->whereIn('gender', $request['gender']);
//        }
//        if (isset($request['civil'])) {
//            $query->whereIn('civil', $request['civil']);
//        }
//
//        return $query->paginate(1);
        //---------------------------------------
        $users = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos', 'model_info_love', 'portfolio'])
            ->where('name', 'like', $letter . '%')
            ->where('email', '!=', 'admin@admin.com')
            ->orderBy('name');

        if (isset($request['gender'])) {
            $users->whereIn('gender', $request['gender']);
        }
        if (isset($request['civil'])) {
            $users->whereIn('civil', $request['civil']);
        }

        $users = $users->paginate(1);

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

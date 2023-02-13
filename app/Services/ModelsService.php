<?php

namespace App\Services;

use App\Models\User;

class ModelsService
{
    public function alphaOrder($request, $letter = ''): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = User::with('portfolio')
            ->where('name', 'like', $letter . '%')
            ->where('email', '!=', 'admin@admin.com')
            ->orderBy('name');

        if (isset($request['gender'])) {
            $query->whereIn('gender', $request['gender']);
        }
        if (isset($request['civil'])) {
            $query->whereIn('civil', $request['civil']);
        }

        return $query->paginate(20);
    }

    public function modelInfo(int $id)
    {
        $user = User::with(['portfolioWithContestPhoto','portfolios', 'interest', 'modelInfos'])
            ->whereId($id)
            ->first()
            ->toArray();

        $user = collect([$user]);

        return $user->map(function ($data) {
            $infos = [];
            if (array_key_exists('model_infos', $data)) {
                $infos = collect($data['model_infos'])->map(function ($info) {
                    return [
                        'rating' => $info['key'] == 'rate' ? $info['value'] : '',
                    ];
                });
            }
            return [
                'name' => $data['name'],
                'email' => $data['email'],
                'infos' => $infos,
            ];
        });
    }
}

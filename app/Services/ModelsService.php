<?php

namespace App\Services;

use App\Models\User;

class ModelsService
{
    public function alphaOrder($letter = ''): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::with('portfolio')
            ->where('name', 'like', $letter . '%')
            ->where('email', '!=', 'admin@admin.com')
            ->orderBy('name')
            ->paginate(20);
    }

    public function modelInfo(int $id)
    {
        return User::with(['portfolioWithContestPhoto', 'interest'])
            ->whereId($id)
            ->first();
    }
}

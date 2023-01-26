<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContestService
{
    public function getContest()
    {
        $data = Contest::with('users.portfolio')->take(1)->get();

        return $data;
    }
}

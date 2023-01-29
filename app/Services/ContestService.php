<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestVotingResult;
use Illuminate\Support\Facades\Auth;

class ContestService
{
    public function getContest()
    {
        $getAlreadyVotedUsers = ContestVotingResult::where('user_id', Auth::user()->id)->select('contest_id')->get();
        $data = Contest::with('users.portfolio')->whereNotIn('id', $getAlreadyVotedUsers)->take(1)->get();

        return $data;
    }
}

<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\ContestVotingResult;
use Illuminate\Support\Facades\Auth;

class ContestService
{
    public function getContest(): \Illuminate\Database\Eloquent\Collection|array
    {
        $contestParticipants = ContestParticipants::where('user_id', Auth::user()->id)->select('contest_id')->get();
        $getAlreadyVotedUsers = ContestVotingResult::where('user_id', Auth::user()->id)->select('contest_id')->get();
        return Contest::with('users.portfolio')->whereNotIn('id', $getAlreadyVotedUsers)->whereNotIn('id', $contestParticipants)->take(1)->get();
    }

    public function vote($contestId, $modelId)
    {
        $voting = new ContestVotingResult;
        $voting->contest_id = $contestId;
        $voting->user_id = Auth::user()->id;
        $voting->whom_vote = $modelId;
        $voting->vote_count = 1;
        $voting->save();

        return $voting->id;
    }
}

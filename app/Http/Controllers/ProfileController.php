<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile($username)
    {
        $data = User::with(['portfolio', 'portfolios', 'state_name'])->where('username', $username)->first();

        $userid_get = User::where('username', $username)->select('id')->first();
        $userId = $userid_get->id; // specify the user ID here

        $result = DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->join('portfolios', 'portfolios.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext')
            ->where('whom_vote', $userId)
            ->where('portfolios.profile_photo', 1)
            ->groupBy('contest_id', 'whom_vote')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'winners' => $group->take(3)->map(function ($item) {
                        return [
                            'username' => $item->username,
                            'user_name' => $item->user_name,
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                        ];
                    })
                ];
            });

        $contestsWon = $result->count();

        return view('profile.profile', compact('data', 'contestsWon'));
    }
}

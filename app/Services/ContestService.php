<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\ContestVotingResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContestService
{

    public function userContestPhoto(): object
    {
        return User::with(['portfolio_without_profile_photo' => function($query) {
            $query->where('contest_photo', 1);
        }])->where('id', \auth()->user()->id)->first();
    }
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

    public function my_contests()
    {
//        return DB::table('contest_voting_results')
//            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
//            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
//            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name',
//                DB::raw('SUM(vote_count) as total_votes'))
//            ->where('users.id', \auth()->user()->id)
//            ->groupBy('contest_id', 'whom_vote')
//            ->orderBy('contest_id')
//            ->orderByDesc('total_votes')
//            ->get()
//            ->groupBy('contest_id')
//            ->map(function ($group) {
//                return [
//                    'contest_id' => $group->first()->contest_id,
//                    'contest_name' => $group->first()->contest_name,
//                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
//                    'winners' => $group->take(3)->map(function ($item) {
//                        return [
//                            'user_name' => $item->user_name,
//                            'total_votes' => $item->total_votes,
//                        ];
//                    })
//                ];
//            });

        return Contest::join('contest_participants', 'contests.id', '=', 'contest_participants.contest_id')
            ->where('contest_participants.user_id', \auth()->user()->id)
            ->get()
            ->map(function ($group) {
            return [
                'contest_id' => $group->id,
                'contest_name' => $group->title,
                'start' => Carbon::parse($group->start)->format('jS F Y'),
            ];
        });
    }

    public function getWinners($month = '', $year = '')
    {
        if($month == '') {
            $month = Carbon::now()->month;
        }
        if($year == '') {
            $year = Carbon::now()->year;
        }
        return DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->join('portfolios', 'portfolios.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext')
            ->whereMonth("contests.start", $month)
            ->whereYear('contests.start', $year)
            ->where('portfolios.profile_photo', 1)
            ->groupBy('contest_id', 'whom_vote')
            ->orderBy('contest_id')
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
    }

    public function my_results()
    {
        return DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->join('portfolios', 'portfolios.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext')
            ->where('users.id', \auth()->user()->id)
            ->where('portfolios.profile_photo', 1)
            ->groupBy('contest_id', 'whom_vote')
            ->orderBy('contest_id')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                $winners = $group->take(3)->map(function ($item) {
                    return [
                        'username' => $item->username,
                        'user_name' => $item->user_name,
                        'user_image' => [
                            'image_path' => $item->file_name . '.' . $item->ext,
                        ],
                        'total_votes' => $item->total_votes,
                    ];
                });

                $isWinner = false;
                foreach ($winners as $winner) {
                    if ($winner['username'] == \auth()->user()->username) {
                        $isWinner = true;
                        break;
                    }
                }

                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'winners' => $winners,
                    'winner' => $isWinner ? 'Won' : '',
                ];
            });
    }
}

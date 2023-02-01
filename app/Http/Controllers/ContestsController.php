<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestVotingResult;
use App\Models\User;
use App\Services\ContestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContestsController extends Controller
{
    public function index_vote(ContestService $contestService)
    {
        //$data = $contestService->getContest();
        return view('contests.index_vote');
    }

    public function my_contests()
    {
        $myContests = User::with(['contestes' => function ($query) {
            $query->where('start', '<=', date('Y-m-d'));
            $query->with(['voting_results' => function($query) {
                //$query->where('whom_vote', Auth::user()->id);
            }]);
        }, 'portfolio'])->where('id', Auth::user()->id)->first();


        $results_s = DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name',
                DB::raw('SUM(vote_count) as total_votes'))
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
                            'user_name' => $item->user_name,
                            'total_votes' => $item->total_votes,
                        ];
                    })
                ];
            });

        return view('contests.my-contest', compact('myContests', 'results_s'));
    }
}

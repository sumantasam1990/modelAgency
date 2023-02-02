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
    public function index_vote(ContestService $contestService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('contests.index_vote');
    }

    public function my_contests(ContestService $contestService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $myContests = $contestService->userContestPhoto();
        $results_s = $contestService->my_contests();
        return view('contests.my-contest', compact('myContests', 'results_s'));
    }

    public function winners(ContestService $contestService, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = $contestService->getWinners();
        return view('contests.winners', compact('data', 'request'));
    }

    public function winner_search(ContestService $contestService, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = $contestService->getWinners($request->month, $request->year);
        return view('contests.winners', compact('data', 'request'));
    }

    public function my_results()
    {
        $data = DB::table('contest_voting_results')
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


        return view('contests.my_results', compact('data'));
    }
}

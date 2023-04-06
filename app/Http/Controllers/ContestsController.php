<?php

namespace App\Http\Controllers;

use App\Models\AdminText;
use App\Models\BankTransfer;
use App\Models\Contest;
use App\Models\ContestVotingResult;
use App\Models\User;
use App\Services\ContestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContestsController extends Controller
{
    public function index_vote(ContestService $contestService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('contests.index_vote');
    }

    public function my_contests(ContestService $contestService)
    {
       // Cache::delete('photo-user-' . Auth::user()->id);
        $myContests = $contestService->userContestPhoto();
        $results_s = $contestService->my_contests();

        return view('contests.my-contest', compact('myContests', 'results_s'));
    }

    public function winners(ContestService $contestService, Request $request)
    {
        $data = $contestService->winners();
        return view('contests.winners', compact('data', 'request'));
    }

    public function winner_search(ContestService $contestService, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = $contestService->winners($request->month, $request->year);
        return view('contests.winners', compact('data', 'request'));
    }

    public function my_results(ContestService $contestService)
    {
        $data = $contestService->my_results();
        $text_prize_sent = AdminText::where('key', '=', 'prize_sent')->select('id', 'value')->first();
        $text_lose = AdminText::where('key', '=', 'lose')->select('id', 'value')->first();
        $text_win = AdminText::where('key', '=', 'win')->select('id', 'value')->first();
        return view('contests.my_results', compact('data', 'text_win', 'text_lose', 'text_prize_sent'));
    }
}

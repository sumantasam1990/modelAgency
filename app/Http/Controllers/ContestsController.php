<?php

namespace App\Http\Controllers;

use App\Services\ContestService;
use Illuminate\Http\Request;

class ContestsController extends Controller
{
    public function index_vote(ContestService $contestService)
    {
        //$data = $contestService->getContest();
        return view('contests.index_vote');
    }
}

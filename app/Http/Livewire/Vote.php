<?php

namespace App\Http\Livewire;

use App\Models\ContestVotingResult;
use App\Services\ContestService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Vote extends Component
{
    public bool $disabled = false;
    public function render(ContestService $contestService)
    {
        $data = $contestService->getContest();
        return view('livewire.vote', compact('data'));
    }

    public function voteup(ContestService $contestService, $contestId, $modelId)
    {
        $contestService->vote($contestId, $modelId);
    }
}

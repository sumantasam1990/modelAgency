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

    public function voteup($contestId, $modelId)
    {
        $this->disabled = true;
        $voting = new ContestVotingResult;
        $voting->contest_id = $contestId;
        $voting->user_id = Auth::user()->id;
        $voting->whom_vote = $modelId;
        $voting->save();

        if($voting->id)
        {
            $this->disabled = false;
        }
    }
}

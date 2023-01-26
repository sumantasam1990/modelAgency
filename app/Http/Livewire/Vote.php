<?php

namespace App\Http\Livewire;

use App\Services\ContestService;
use Livewire\Component;

class Vote extends Component
{
    public $disabled = false;
    public function render(ContestService $contestService)
    {
        $data = $contestService->getContest();
        return view('livewire.vote', compact('data'));
    }

    public function voteup()
    {
        $this->disabled = true;
    }
}

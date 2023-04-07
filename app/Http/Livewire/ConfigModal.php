<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Services\ContestService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConfigModal extends Component
{
    public int $userId;

    public $data;

    public function showUserInfo(ContestService $contestService)
    {
        $this->data = $contestService->getAdminModelConfigData($this->userId);
    }
    public function render(ContestService $contestService)
    {
        $this->data = $contestService->getAdminModelConfigData($this->userId);
        return view('livewire.config-modal', ['data' => $this->data]);
    }
}

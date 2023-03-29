<?php

namespace App\Http\Livewire;

use App\Models\Interest;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class ShowUserModal extends Component
{
    public int $userId;

    public $data;

    public function showUser()
    {
        $this->data = User::whereId($this->userId)
            ->select('about')
            ->first();
    }
    public function render()
    {
        return view('livewire.show-user-modal');
    }
}

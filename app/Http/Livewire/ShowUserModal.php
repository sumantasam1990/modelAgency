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
        $this->data = User::where('id', $this->userId)
            ->select('about')
            ->first();
    }
    public function render()
    {
        $this->data = User::where('id', $this->userId)
            ->select('about')
            ->first();
        return view('livewire.show-user-modal', ['data' => $this->data]);
    }
}

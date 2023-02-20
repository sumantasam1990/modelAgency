<?php

namespace App\Http\Livewire;

use App\Models\AdminNote;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminNotes extends Component
{
    public $note;
    public $uid;

    public function render()
    {
        return view('livewire.admin-notes');
    }

    public function saveNote()
    {
        if (!empty($this->note))
        {
            AdminNote::updateOrInsert(
                ['user_id' => Auth::user()->id, 'to_user_id' => $this->uid],
                ['user_id' => Auth::user()->id, 'to_user_id' => $this->uid, 'note' => $this->note]
            );
        }
    }
}

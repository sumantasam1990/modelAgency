<?php

namespace App\Http\Livewire;

use App\Models\Contest;
use Livewire\Component;

class ContestsWithCategory extends Component
{
    public $selectedValue;
    public $data;
    public function render()
    {
        return view('livewire.contests-with-category');
    }

    public function updatedSelectedValue($value)
    {
        // perform the desired action
        // for example, get data based on the selected value
        $this->data = Contest::whereCategoryId($value)->first();
    }
}

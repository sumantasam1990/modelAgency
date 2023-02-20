<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StateCitySelectBox extends Component
{
    public $selectedState;
    public $selectedCity = [];

    public function render()
    {
        //$this->selectedState = $this->post;
        $states = DB::table('tb_estados')
            ->select('id', 'uf', 'nome')
            ->get();

        $cities = DB::table('tb_cidades')
            ->where('estado', '=', $this->selectedState)
            ->get();

        return view('livewire.state-city-select-box', [
            'states' => $states,
            'cities' => $cities,
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
// use carbon\Carbon;

class Polling extends Component
{
    public function render()
    {
        return view('livewire.example-component', [
            'items' => Model::all(),
        ]);
        
    }
}

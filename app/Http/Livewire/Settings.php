<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Settings extends Component
{
    public function render()
    {
        return view('livewire.settings.component')
        ->layout('layouts.theme.app');
    }
}

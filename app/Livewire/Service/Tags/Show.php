<?php

namespace App\Livewire\Service\Tags;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Show extends Component
{
    // Define a reactive property to hold the services data
    #[Reactive]
    public $services;

    public function render()
    {
        return view('livewire.service.tags.show');
    }
}

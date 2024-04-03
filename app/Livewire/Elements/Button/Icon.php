<?php

namespace App\Livewire\Elements\Button;

use Livewire\Component;

class Icon extends Component
{
    public $attributes=null;
    public function render($attributes=null)
    {
        dd($attributes);
        return view('livewire.elements.button.icon');
    }
}

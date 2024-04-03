<?php

namespace App\View\Components\elements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class pagination extends Component
{
    /**
     * Create a new component instance.
     */
    public $paginator;
    public function __construct($paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // dd($this->paginator);
        return view('components.elements.pagination');
    }
}

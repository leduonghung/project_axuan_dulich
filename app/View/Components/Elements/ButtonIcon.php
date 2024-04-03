<?php

namespace App\View\Components\Elements;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonIcon extends Component
{
    public $cname;
    public $url;
    public $iconClass;
    /**
     * Create a new component instance.
     */
    public function __construct($cname,$url,$iconClass)
    {
        $this->cname = $cname;
        $this->url = $url;
        $this->iconClass = $iconClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.elements.button-icon');
    }
}

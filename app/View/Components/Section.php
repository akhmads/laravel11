<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Section extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.section');
    }
}

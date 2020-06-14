<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public string $name;
    public string $label;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function render(): View
    {
        return view('components.input');
    }
}

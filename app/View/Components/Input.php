<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public ?string $errorBag = null,
    ) {}

    public function render(): View
    {
        return view('components.input');
    }
}

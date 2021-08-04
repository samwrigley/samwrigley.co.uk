<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TextArea extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public ?string $value = null,
        public ?string $errorBag = null,
    ) {}

    public function render(): View
    {
        return view('components.textarea');
    }
}

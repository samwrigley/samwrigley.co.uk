<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public string $name;
    public string $label;
    public ?string $errorBag;

    public function __construct(
        string $name,
        string $label,
        ?string $errorBag = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->errorBag = $errorBag;
    }

    public function render(): View
    {
        return view('components.input');
    }
}

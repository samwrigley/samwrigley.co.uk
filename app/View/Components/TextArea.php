<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TextArea extends Component
{
    public string $name;
    public string $label;
    public ?string $value;
    public ?string $errorBag;

    public function __construct(
        string $name,
        string $label,
        ?string $value = null,
        ?string $errorBag = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->errorBag = $errorBag;
    }

    public function render(): View
    {
        return view('components.textarea');
    }
}

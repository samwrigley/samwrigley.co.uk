<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    public string $name;
    public string $label;
    public Collection $items;

    public function __construct(string $name, string $label, Collection $items)
    {
        $this->name = $name;
        $this->label = $label;
        $this->items = $items;
    }

    public function render(): View
    {
        return view('components.select');
    }
}

<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public Collection $items,
        public array|string|int|null $selected = null,
        public ?string $errorBag = null,
    ) {
    }

    public function render(): View
    {
        return view('components.select');
    }

    public function isSelected(string $option): bool
    {
        if (is_null($this->selected)) {
            return false;
        }

        if (is_array($this->selected)) {
            return in_array($option, $this->selected);
        }

        return $option === (string) $this->selected;
    }
}

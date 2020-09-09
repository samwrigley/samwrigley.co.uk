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

    /** @var array|string|int|null */
    public $selected;

    public ?string $errorBag;

    public function __construct(
        string $name,
        string $label,
        Collection $items,
        $selected = null,
        $errorBag = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->items = $items;
        $this->selected = $selected;
        $this->errorBag = $errorBag;
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

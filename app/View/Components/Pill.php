<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Pill extends Component
{
    public const GREEN = 'green';
    public const ORANGE = 'orange';
    public const YELLOW = 'yellow';

    public function __construct(
        public string $text,
        public string $colour
    ) {
    }

    public function render(): View
    {
        return view('components.pill');
    }

    public function colourClasses(): string
    {
        return match ($this->colour) {
            self::GREEN => 'bg-green-200 text-green-800',
            self::ORANGE => 'bg-orange-200 text-orange-800',
            self::YELLOW => 'bg-yellow-200 text-yellow-800',
            default => '',
        };
    }
}

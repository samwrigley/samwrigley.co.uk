<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Pill extends Component
{
    public const GREEN = 'green';
    public const ORANGE = 'orange';
    public const YELLOW = 'yellow';

    public string $text;
    public string $colour;

    public function __construct(string $text, string $colour)
    {
        $this->text = $text;
        $this->colour = $colour;
    }

    public function render(): View
    {
        return view('components.pill');
    }

    public function backgroundClasses(): string
    {
        switch ($this->colour) {
            case self::GREEN:
                return 'bg-green-200 text-green-800';
            case self::ORANGE:
                return 'bg-orange-200 text-orange-800';
            case self::YELLOW:
                return 'bg-yellow-200 text-yellow-800';
            default:
                return '';
        }
    }
}

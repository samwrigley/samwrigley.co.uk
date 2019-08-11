<?php

namespace App\Traits;

trait HasAge
{
    public function isNew(int $months = 1, $attribute = 'published_at'): bool
    {
        return $this->{$attribute} >= now()->subMonths($months);
    }

    public function isOld(int $months = 6, $attribute = 'published_at'): bool
    {
        return $this->{$attribute} < now()->subMonths($months);
    }
}

<?php

namespace App\Traits;

trait HasAge
{
    public function isNew(int $months = 1, string $attribute = 'published_at'): bool
    {
        return $this->{$attribute} >= now()->subMonths($months);
    }

    public function isOld(int $months = 6, string $attribute = 'published_at'): bool
    {
        return $this->{$attribute} < now()->subMonths($months);
    }
}

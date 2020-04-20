<?php

namespace App\Traits;

use App\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InSeries
{
    abstract public function series(): BelongsTo;

    public function scopeWithSeries(Builder $query): Builder
    {
        return $query->with('series');
    }

    public function nextInSeries(): ?Article
    {
        return $this->series
            ->hasMany(Article::class)
            ->published()
            ->whereDate('published_at', '>', $this->published_at)
            ->oldest('published_at')
            ->first();
    }

    public function previousInSeries(): ?Article
    {
        return $this->series
            ->hasMany(Article::class)
            ->published()
            ->whereDate('published_at', '<', $this->published_at)
            ->latest('published_at')
            ->first();
    }
}

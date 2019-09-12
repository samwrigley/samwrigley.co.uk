<?php

namespace App\Traits;

use App\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InSeries
{
    abstract public function series(): BelongsTo;

    /**
     * Scope a query to eager load `series`
     * relationship to reduce database queries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSeries(Builder $query)
    {
        return $query->with('series');
    }

    public function next(): ?Article
    {
        return $this->series->articles->find($this->id + 1);
    }

    public function previous(): ?Article
    {
        return $this->series->articles->find($this->id - 1);
    }
}

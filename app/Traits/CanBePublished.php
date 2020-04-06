<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait CanBePublished
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $canBePublishedFillable = [
        'published_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $canBePublishedDates = [
        'published_at',
    ];

    public static function bootCanBePublished(): void
    {
        static::retrieved(
            function ($model) {
                $model->fillable = array_merge(
                    $model->fillable,
                    $model->canBePublishedFillable
                );

                $model->dates = array_merge(
                    $model->dates,
                    $model->canBePublishedDates
                );
            }
        );
    }

    public function markAsPublished(): void
    {
        $this->published_at = now();
        $this->save();
    }

    public function markAsScheduled(Carbon $publishedDateTime): void
    {
        $this->published_at = $publishedDateTime;
        $this->save();
    }

    public function markAsDraft(): void
    {
        $this->published_at = null;
        $this->save();
    }

    public function isPublished(): bool
    {
        return $this->published_at <= now();
    }

    public function isScheduled(): bool
    {
        return $this->published_at > now();
    }

    public function isDraft(): bool
    {
        return is_null($this->published_at);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '>', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->whereNull('published_at');
    }

    public function scopePublishedInMonth(Builder $query, string $month): Builder
    {
        return $query->whereMonth('published_at', $month);
    }

    public function scopePublishedInYear(Builder $query, string $year): Builder
    {
        return $query->whereYear('published_at', $year);
    }

    public function scopePublishedBetween(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->whereBetween('published_at', [$start, $end]);
    }

    public function scopePublishedBefore(Builder $query, Carbon $before): Builder
    {
        return $query->where('published_at', '<', $before);
    }

    public function scopePublishedAfter(Builder $query, Carbon $after): Builder
    {
        return $query->where('published_at', '>', $after);
    }
}

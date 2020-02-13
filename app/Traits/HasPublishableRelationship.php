<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasPublishableRelationship
{
    public function scopeHasPublished(Builder $query, string $relation): Builder
    {
        return $query->whereHas(
            $relation,
            static function (Builder $query): void {
                $query->published();
            }
        );
    }

    public function scopeHasScheduled(Builder $query, string $relation): Builder
    {
        return $query->whereHas(
            $relation,
            static function (Builder $query): void {
                $query->scheduled();
            }
        );
    }

    public function scopeHasDraft(Builder $query, string $relation): Builder
    {
        return $query->whereHas(
            $relation,
            static function (Builder $query): void {
                $query->draft();
            }
        );
    }
}

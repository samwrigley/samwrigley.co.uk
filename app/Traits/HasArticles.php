<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasArticles
{
    abstract public function articles(): BelongsToMany;

    public function scopeWithArticle(Builder $query): Builder
    {
        return $query->with('articles');
    }

    public function articleCount(): int
    {
        return $this->articles()->count();
    }

    public function publishedArticleCount(): int
    {
        return $this->articles()
            ->published()
            ->count();
    }

    public function scheduledArticleCount(): int
    {
        return $this->articles()
            ->scheduled()
            ->count();
    }

    public function draftArticleCount(): int
    {
        return $this->articles()
            ->draft()
            ->count();
    }
}

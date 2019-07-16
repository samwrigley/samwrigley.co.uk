<?php

namespace App;

use App\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSeries extends Model
{
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)
            ->published()
            ->oldest('published_at');
    }
}

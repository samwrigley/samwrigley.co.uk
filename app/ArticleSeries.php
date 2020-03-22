<?php

namespace App;

use App\Article;
use App\Model;
use App\Traits\HasArticles;
use App\Traits\HasPublishableRelationship;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSeries extends Model
{
    use HasArticles;
    use HasPublishableRelationship;

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)
            ->published()
            ->oldest('published_at');
    }
}

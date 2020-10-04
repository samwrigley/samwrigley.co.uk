<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Model;
use App\Traits\ClearsResponseCache;
use App\Traits\HasArticles;
use App\Traits\HasPublishableRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSeries extends Model
{
    use ClearsResponseCache;
    use HasArticles;
    use HasFactory;
    use HasPublishableRelationship;

    public array $routeNamespaces = [
        'web' => 'blog.series.',
        'admin' => 'admin.blog.series.',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 9;

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)
            ->published()
            ->oldest('published_at');
    }
}

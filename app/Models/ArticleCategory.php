<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Model;
use App\Traits\ClearsResponseCache;
use App\Traits\HasArticles;
use App\Traits\HasPublishableRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleCategory extends Model
{
    use ClearsResponseCache;
    use HasArticles;
    use HasFactory;
    use HasPublishableRelationship;

    public array $routeNamespaces = [
        'web' => 'blog.categories.',
        'admin' => 'admin.blog.categories.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 9;

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)
            ->withTimestamps()
            ->latest('published_at');
    }
}

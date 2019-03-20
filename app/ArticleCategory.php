<?php

namespace App;

use App\Article;
use App\Model;
use App\Traits\HasArticles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleCategory extends Model
{
    use HasArticles;

    /**
     * The route namespace.
     *
     * @var string[]
     */
    protected $namespaces = [
        'web' => 'article.categories.',
        'admin' => 'admin.article.categories.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

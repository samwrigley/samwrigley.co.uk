<?php

namespace App;

use App\Article;
use App\Model;
use App\Traits\BelongsToManyArticles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleCategory extends Model
{
    use BelongsToManyArticles;

    /**
     * The route namespace.
     *
     * @var string[]
     */
    protected $namespaces = [
        'web' => 'blog.categories.',
        'admin' => 'admin.blog.categories.',
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

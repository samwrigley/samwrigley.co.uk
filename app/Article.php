<?php

namespace App;

use App\ArticleCategory;
use App\Model;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SamWrigley\Support\Traits\CanBePublished;
use SamWrigley\Support\Traits\HasAuthor;
use SamWrigley\Support\Traits\HasCategories;

class Article extends Model
{
    use HasAuthor;
    use HasCategories;
    use CanBePublished;

    /**
     * The route namespace.
     *
     * @var string[]
     */
    protected $namespaces = [
        'web' => 'blog.articles.',
        'admin' => 'admin.articles.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var string[]
     */
    protected $with = [
        'categories',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ArticleCategory::class);
    }
}

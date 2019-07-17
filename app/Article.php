<?php

namespace App;

use App\ArticleCategory;
use App\ArticleSeries;
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
        'featured_image',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 9;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ArticleCategory::class)->withTimestamps();
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(ArticleSeries::class, 'article_series_id');
    }

    public function isNew(int $months = 1): bool
    {
        return $this->published_at >= now()->subMonths($months);
    }

    public function isOld(int $months = 6): bool
    {
        return $this->published_at < now()->subMonths($months);
    }

    public function next(): ?self
    {
        return $this->series->articles->find($this->id + 1);
    }

    public function previous(): ?self
    {
        return $this->series->articles->find($this->id - 1);
    }
}

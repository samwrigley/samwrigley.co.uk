<?php

namespace App\Models;

use App\Models\ArticleCategory;
use App\Models\ArticleSeries;
use App\Models\Model;
use App\Models\User;
use App\Traits\CanBePublished;
use App\Traits\ClearsResponseCache;
use App\Traits\HasAge;
use App\Traits\InSeries;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends Model implements Feedable
{
    use CanBePublished;
    use ClearsResponseCache;
    use HasAge;
    use HasFactory;
    use InSeries;

    public const MAX_TITLE_LENGTH = 255;
    public const MAX_SLUG_LENGTH = 255;
    public const MAX_EXCERPT_LENGTH = 500;

    public array $routeNamespaces = [
        'web' => 'blog.articles.',
        'admin' => 'admin.articles.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'featured_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
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

    public function scopeWithAuthor(Builder $query): Builder
    {
        return $query->with('author');
    }

    public function scopeWithCategories(Builder $query): Builder
    {
        return $query->with('categories');
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id((string) $this->id)
            ->title($this->title)
            ->summary($this->excerpt)
            ->updated($this->published_at)
            ->link($this->showRoute())
            ->author($this->author->name);
    }

    public static function getFeedItems(): Collection
    {
        return self::published()->get();
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}

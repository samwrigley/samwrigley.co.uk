<?php

namespace App\Traits;

use App\Traits\HasArticles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasManyArticles
{
    use HasArticles;

    /**
     * Add article to item.
     *
     * @param  mixed  $articleId
     * @return void
     */
    public function addArticle($articleId): void
    {
        $this->articles()->save($articleId);
    }

    /**
     * Add articles to item.
     *
     * @param  mixed  $articleIds
     * @return void
     */
    public function addArticles($articleIds): void
    {
        $this->articles()->saveMany($articleIds);
    }
}

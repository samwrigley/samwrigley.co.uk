<?php

namespace App\Traits;

use App\Traits\HasArticles;

trait BelongsToManyArticles
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
        $this->articles()->attach($articleId);
    }

    /**
     * Add articles to item.
     *
     * @param  mixed  $articleIds
     * @return void
     */
    public function addArticles($articleIds): void
    {
        $this->articles()->attach($articleIds);
    }
}

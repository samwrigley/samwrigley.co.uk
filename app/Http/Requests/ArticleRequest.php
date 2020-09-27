<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'article';

    protected function prepareForValidation(): void
    {
        $this->removeEmptyCategories();
    }

    public function rules(): array
    {
        $article = $this->route('article');
        $articleId = optional($article)->id;
        $maxTitleLength = Article::MAX_TITLE_LENGTH;
        $maxSlugLength = Article::MAX_SLUG_LENGTH;
        $maxExcerptLength = Article::MAX_EXCERPT_LENGTH;
        $publishedDateFormat = Article::$PUBLISHED_DATE_FORMAT;
        $publishedTimeFormat = Article::$PUBLISHED_TIME_FORMAT;

        return [
            'title' => [
                'required',
                'string',
                "max:{$maxTitleLength}",
                Rule::unique('articles')->ignore($articleId),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                "max:{$maxSlugLength}",
                Rule::unique('articles')->ignore($articleId),
            ],
            'excerpt' => [
                'nullable',
                'string',
                "max:{$maxExcerptLength}",
            ],
            'body' => [
                'required',
                'string',
            ],
            'date' => [
                'nullable',
                "date_format:{$publishedDateFormat}",
                'required_with:time',
            ],
            'time' => [
                'nullable',
                "date_format:{$publishedTimeFormat}",
                'required_with:date',
            ],
            'categories' => [
                'nullable',
                'array',
            ],
            'series' => [
                'nullable',
                'string',
                'exists:article_series,id',
            ],
        ];
    }

    public function validated(): array
    {
        $validatedData = collect($this->validator->validated());

        if ($publishedAt = $this->getPublishedAt()) {
            $validatedData->put('published_at', $publishedAt);
            $validatedData->forget(['date', 'time']);
        }

        return $validatedData->toArray();
    }

    protected function removeEmptyCategories(): void
    {
        $this->categories = collect($this->categories)
            ->reject(fn (?string $category): bool => is_null($category));
    }

    protected function getPublishedAt(): ?Carbon
    {
        return $this->filled(['date', 'time'])
            ? Carbon::parse("{$this->date} {$this->time}")
            : null;
    }
}

<?php

namespace App\Http\Requests;

use App\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    public $errorBag = 'article';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $article = $this->route('article');
        $articleId = optional($article)->id;
        $maxExcerptLength = Article::MAX_EXCERPT_LENGTH;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles')->ignore($articleId),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('articles')->ignore($articleId),
            ],
            'excerpt' => "nullable|max:{$maxExcerptLength}",
            'body' => 'required',
            'categories' => 'nullable|array',
            'date' => 'required_with:time|date|after:yesterday',
            'time' => 'required_with:date|date_format:H:i',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'article';

    public function rules(): array
    {
        $article = $this->route('article');
        $articleId = optional($article)->id;

        return [
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('articles')->ignore($articleId),
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'max:50',
                Rule::unique('articles')->ignore($articleId),
            ],
            'excerpt' => 'nullable|max:500',
            'body' => 'required',
            'categories' => 'nullable|array',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleCategoryRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'article_category';

    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = $category?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('article_categories')->ignore($categoryId),
            ],
            'slug' => [
                'required',
                'string',
                'max:50',
                Rule::unique('article_categories')->ignore($categoryId),
            ],
            'description' => [
                'nullable',
                'max:500',
            ],
        ];
    }
}

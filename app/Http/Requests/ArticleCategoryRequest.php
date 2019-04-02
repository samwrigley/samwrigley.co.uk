<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = optional($category)->id;

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
            'description' => 'nullable|max:500',
        ];
    }
}

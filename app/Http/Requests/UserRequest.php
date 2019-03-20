<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $userId = optional($user)->id;

        return [
            'name' => [
                'required',
                'string',
            ],
            'slug' => [
                'required',
                'alpha_dash',
                'max:50',
                Rule::unique('users')->ignore($userId),
            ],
            'bio' => 'nullable|max:500',
        ];
    }
}

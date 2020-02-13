<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    public $errorBag = 'contact';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ];
    }
}

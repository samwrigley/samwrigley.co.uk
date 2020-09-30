<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    public $errorBag = 'contact';

    public function rules(): array
    {
        $maxMessageLength = Contact::MAX_MESSAGE_LENGTH;

        return [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
            ],
            'message' => [
                'required',
                'string',
                "max:{$maxMessageLength}",
            ],
        ];
    }
}

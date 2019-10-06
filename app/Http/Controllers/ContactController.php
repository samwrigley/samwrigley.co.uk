<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function __invoke(ContactRequest $request): RedirectResponse
    {
        Log::info("Contact: {$request->email}");

        return Redirect::back()->with('contact', 'Thank you for getting in touch!');
    }
}

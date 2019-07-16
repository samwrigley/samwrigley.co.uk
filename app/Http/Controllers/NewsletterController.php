<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request): RedirectResponse
    {
        Log::info("Newsletter subscription: {$request->email}");

        return Redirect::back()->with('newsletter', 'Thank you for subscribing!');
    }
}

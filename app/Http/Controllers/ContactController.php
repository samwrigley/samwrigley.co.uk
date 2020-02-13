<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::create($request->all());

        Log::info("Contact: {$request->email}");

        return Redirect::back()->with($request->errorBag, 'Thank you for getting in touch!');
    }
}

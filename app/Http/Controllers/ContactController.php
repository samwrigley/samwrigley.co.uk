<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use App\Notifications\ContactReceived;
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
        $contact = Contact::create($request->only(['name', 'email', 'message']));

        Log::info("Contact: {$request->email}");
        $contact->notify(new ContactReceived($contact));

        return Redirect::back()->with($request->errorBag, __('contact.success'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Notifications\ContactReceived;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request): Response
    {
        $contact = Contact::create($request->only(['name', 'email', 'message']));

        Notification::route('slack', Config::get('notifications.slack.contact'))
            ->notify(new ContactReceived($contact));

        Log::info("{$request->name} has been in touch using '{$request->email}'");

        if ($request->wantsJson()) {
            return response()->json(['message' => __('contact.success')]);
        }

        return Redirect::back()->with($request->errorBag, __('contact.success'));
    }
}

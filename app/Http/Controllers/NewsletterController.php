<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\Notifications\NewsletterSubscribed;
use App\Notifications\NewsletterUnsubscribed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request): RedirectResponse
    {
        if (Newsletter::isSubscribed($request->email)) {
            Log::info('Newsletter: Already subscribed', ['email' => $request->email]);

            return Redirect::back()->with('newsletter', __('newsletter.already_subscribed'));
        }

        if (! Newsletter::subscribe($request->email)) {
            Log::error('Newsletter: Subscribe failure', ['message' => Newsletter::getLastError()]);

            return Redirect::back()->with('newsletter', __('newsletter.subscribe_failure'));
        }

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterSubscribed($request->email));

        Log::info('Newsletter: Subscribed', ['email' => $request->email]);

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_success'));
    }

    public function destroy(NewsletterRequest $request): RedirectResponse
    {
        if (! Newsletter::isSubscribed($request->email)) {
            Log::info('Newsletter: Already unsubscribed', ['email' => $request->email]);

            return Redirect::back()->with('newsletter', __('newsletter.already_unsubscribed'));
        }

        if (! Newsletter::unsubscribe($request->email)) {
            Log::error('Newsletter: Unsubscribe failure', ['message' => Newsletter::getLastError()]);

            return Redirect::back()->with('newsletter', __('newsletter.unsubscribe_failure'));
        }

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterUnsubscribed($request->email));

        Log::info('Newsletter: Unsubscribed', ['email' => $request->email]);

        return Redirect::back()->with('newsletter', __('newsletter.unsubscribe_success'));
    }
}

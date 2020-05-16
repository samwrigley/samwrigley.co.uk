<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\NewsletterSubscription;
use App\Notifications\NewsletterSubscribed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Newsletter;

class NewsletterSubscriptionController extends Controller
{
    public function __invoke(NewsletterRequest $request): RedirectResponse
    {
        if (Newsletter::isSubscribed($request->email)) {
            Log::info('Newsletter: Already subscribed', ['email' => $request->email]);

            return Redirect::back()->with('newsletter', __('newsletter.already_subscribed'));
        }

        if (! Newsletter::subscribe($request->email)) {
            Log::error('Newsletter: Subscribe failure', ['message' => Newsletter::getLastError()]);

            return Redirect::back()->with('newsletter', __('newsletter.subscribe_failure'));
        }

        NewsletterSubscription::create(['email' => $request->email]);

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterSubscribed($request->email));

        Log::info('Newsletter: Subscribed', ['email' => $request->email]);

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_success'));
    }
}

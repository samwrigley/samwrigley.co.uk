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
            return $this->hasSubscribed($request);
        }

        if (app()->isProduction() && ! Newsletter::subscribe($request->email)) {
            return $this->subscribeFailed($request);
        }

        return $this->subscribeSuccessful($request);
    }

    protected function hasSubscribed(NewsletterRequest $request): RedirectResponse
    {
        Log::info('Newsletter : Already subscribed', ['email' => $request->email]);

        return Redirect::back()->with('newsletter', __('newsletter.already_subscribed'));
    }

    protected function subscribeFailed(NewsletterRequest $request): RedirectResponse
    {
        Log::error('Newsletter : Subscribe failed', [
            'email' => $request->email,
            'message' => Newsletter::getLastError(),
        ]);

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_failure'));
    }

    protected function subscribeSuccessful(NewsletterRequest $request): RedirectResponse
    {
        $subscription = NewsletterSubscription::create(['email' => $request->email]);

        Log::info('Newsletter : Subscribed', ['subscription' => $subscription]);

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterSubscribed($subscription));

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_success'));
    }
}

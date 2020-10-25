<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\Models\NewsletterSubscription;
use App\Notifications\NewsletterSubscribed;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Newsletter;
use Symfony\Component\HttpFoundation\Response;

class NewsletterSubscriptionController extends Controller
{
    public function __invoke(NewsletterRequest $request): Response
    {
        if (Newsletter::isSubscribed($request->email)) {
            return $this->hasSubscribed($request);
        }

        if (! Newsletter::subscribe($request->email)) {
            return $this->subscribeFailed($request);
        }

        return $this->subscribeSuccessful($request);
    }

    protected function hasSubscribed(NewsletterRequest $request): Response
    {
        Log::info('Newsletter : Already subscribed', ['email' => $request->email]);

        if ($request->wantsJson()) {
            return response()->json(['message' => __('newsletter.already_subscribed')], Response::HTTP_BAD_REQUEST);
        }

        return Redirect::back()->with('newsletter', __('newsletter.already_subscribed'));
    }

    protected function subscribeFailed(NewsletterRequest $request): Response
    {
        Log::error('Newsletter : Subscribe failed', [
            'email' => $request->email,
            'message' => Newsletter::getLastError(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => __('newsletter.subscribe_failure')], Response::HTTP_BAD_REQUEST);
        }

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_failure'));
    }

    protected function subscribeSuccessful(NewsletterRequest $request): Response
    {
        $subscription = NewsletterSubscription::create(['email' => $request->email]);

        Log::info('Newsletter : Subscribed', ['subscription' => $subscription]);

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterSubscribed($subscription));

        if ($request->wantsJson()) {
            return response()->json(['message' => __('newsletter.subscribe_success')]);
        }

        return Redirect::back()->with('newsletter', __('newsletter.subscribe_success'));
    }
}

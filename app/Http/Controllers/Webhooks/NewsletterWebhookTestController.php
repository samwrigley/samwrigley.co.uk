<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class NewsletterWebhookTestController extends Controller
{
    public function __invoke(): Response
    {
        return response('');
    }
}

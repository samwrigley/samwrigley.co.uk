<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/newsletter', Config::get('webhook-client.names.newsletter'));

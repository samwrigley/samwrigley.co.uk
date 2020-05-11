<?php

namespace App\Providers;

use App\Mixins\TestResponseMixin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

class TestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        TestResponse::mixin(new TestResponseMixin());
    }
}

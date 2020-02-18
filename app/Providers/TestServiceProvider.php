<?php

namespace App\Providers;

use App\Mixins\TestResponseMixin;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        TestResponse::mixin(new TestResponseMixin());
    }
}

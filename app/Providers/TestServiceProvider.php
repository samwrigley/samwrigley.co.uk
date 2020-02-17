<?php

namespace App\Providers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;
use Tests\TestResponseMixin;

class TestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        TestResponse::mixin(new TestResponseMixin());
    }
}

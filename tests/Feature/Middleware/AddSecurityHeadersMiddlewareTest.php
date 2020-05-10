<?php

namespace Tests\Middleware\Feature;

use App\Http\Middleware\AddSecurityHeaders;
use Tests\TestCase;

class AddSecurityHeadersMiddlewareTest extends TestCase
{
    /** @test */
    public function adds_security_headers()
    {
        $this->get(route('home'))
            ->assertHeader(AddSecurityHeaders::HEADER_REFERRER_POLICY)
            ->assertHeader(AddSecurityHeaders::HEADER_X_FRAME_OPTIONS)
            ->assertHeader(AddSecurityHeaders::HEADER_X_XSS_PROTECTION);
    }
}

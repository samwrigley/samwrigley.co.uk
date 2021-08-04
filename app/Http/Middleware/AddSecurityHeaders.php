<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddSecurityHeaders
{
    public const HEADER_REFERRER_POLICY = 'Referrer-Policy';
    public const HEADER_X_FRAME_OPTIONS = 'X-Frame-Options';
    public const HEADER_X_XSS_PROTECTION = 'X-Xss-Protection';

    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $response = $next($request);

        return $response->withHeaders([
            self::HEADER_REFERRER_POLICY => 'no-referrer-when-downgrade',
            self::HEADER_X_FRAME_OPTIONS => 'SAMEORIGIN',
            self::HEADER_X_XSS_PROTECTION => $this->getXssHeaderValue(),
        ]);
    }

    protected function getXssHeaderValue(): string
    {
        $xssHeader = '1; mode=block';

        if ($xssReportUri = env('XSS_REPORT_URI')) {
            $xssHeader .= sprintf('; report="%s"', $xssReportUri);
        }

        return $xssHeader;
    }
}

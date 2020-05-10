<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSecurityHeaders
{
    protected const HEADER_REFERRER_POLICY = 'Referrer-Policy';
    protected const HEADER_X_FRAME_OPTIONS = 'X-Frame-Options';
    protected const HEADER_X_XSS_PROTECTION = 'X-Xss-Protection';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
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

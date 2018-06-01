<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSecurityHeaders
{
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
            'X-Xss-Protection' => $this->xssHeader(),
            'Referrer-Policy' => 'strict-origin',
            'X-Frame-Options' => 'SAMEORIGIN',
        ]);
    }

    /**
     * Cross-site scripting (XSS) header value.
     *
     * @return string
     */
    private function xssHeader()
    {
        $xssHeader = '1; mode=block';

        if ($xssReportUri = env('XSS_REPORT_URI')) {
            $xssHeader .= sprintf('; report="%s"', $xssReportUri);
        }

        return $xssHeader;
    }
}

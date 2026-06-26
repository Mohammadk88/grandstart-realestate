<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GeoTargeting
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('visitor_country')) {
            $country = $this->detectCountry($request->ip());
            Session::put('visitor_country', $country);
        }

        $request->merge(['visitor_country' => Session::get('visitor_country')]);

        return $next($request);
    }

    private function detectCountry(string $ip): string
    {
        // For localhost/private IPs, default to non-Iraq
        if ($this->isPrivateIp($ip)) {
            return Session::get('visitor_country', 'AE');
        }

        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode");
            if ($response) {
                $data = json_decode($response, true);
                return $data['countryCode'] ?? 'AE';
            }
        } catch (\Exception $e) {
            // Silently fail
        }

        return 'AE';
    }

    private function isPrivateIp(string $ip): bool
    {
        return in_array($ip, ['127.0.0.1', '::1'])
            || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale');

        try {
            $codes   = Language::codes();
            $default = Language::getDefaultCode();
        } catch (\Throwable) {
            // Fallback if languages table doesn't exist yet
            $codes   = ['ar', 'en', 'tr'];
            $default = 'ar';
        }

        if (!$locale || !in_array($locale, $codes)) {
            $locale = $default;
        }

        App::setLocale($locale);

        return $next($request);
    }
}

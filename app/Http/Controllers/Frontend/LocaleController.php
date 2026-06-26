<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        try {
            $codes = Language::codes();
        } catch (\Throwable) {
            $codes = ['ar', 'en', 'tr'];
        }

        if (!in_array($locale, $codes)) {
            $locale = Language::getDefaultCode();
        }

        Session::put('locale', $locale);

        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}

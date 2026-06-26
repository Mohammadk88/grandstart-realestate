<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settingsToUpdate = [
            // Company info
            'company_name_ar', 'company_name_en', 'company_name_tr',
            'company_tagline_ar', 'company_tagline_en', 'company_tagline_tr',
            'company_years', 'total_clients', 'countries_count',

            // Contact - Default (Turkey Main Office)
            'phone_default', 'email_default', 'whatsapp_default',
            'address_default_ar', 'address_default_en', 'address_default_tr',

            // Contact - Iraq
            'phone_iraq', 'email_iraq', 'whatsapp_iraq',
            'address_iraq_ar', 'address_iraq_en', 'address_iraq_tr',

            // Social Media
            'facebook_url', 'instagram_url', 'twitter_url',
            'youtube_url', 'linkedin_url', 'tiktok_url',

            // SEO
            'meta_title_ar', 'meta_title_en', 'meta_title_tr',
            'meta_description_ar', 'meta_description_en', 'meta_description_tr',

            // About content
            'about_text_ar', 'about_text_en', 'about_text_tr',

            // Hero
            'hero_title_ar', 'hero_title_en', 'hero_title_tr',
            'hero_subtitle_ar', 'hero_subtitle_en', 'hero_subtitle_tr',
        ];

        foreach ($settingsToUpdate as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            Setting::set('site_logo', 'images/' . $filename);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}

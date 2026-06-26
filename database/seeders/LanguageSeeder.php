<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'code'        => 'ar',
                'name_en'     => 'Arabic',
                'name_native' => 'العربية',
                'direction'   => 'rtl',
                'active'      => true,
                'is_default'  => true,
                'sort_order'  => 1,
            ],
            [
                'code'        => 'en',
                'name_en'     => 'English',
                'name_native' => 'English',
                'direction'   => 'ltr',
                'active'      => true,
                'is_default'  => false,
                'sort_order'  => 2,
            ],
            [
                'code'        => 'tr',
                'name_en'     => 'Turkish',
                'name_native' => 'Türkçe',
                'direction'   => 'ltr',
                'active'      => true,
                'is_default'  => false,
                'sort_order'  => 3,
            ],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], $lang);
        }

        Language::clearCache();
    }
}

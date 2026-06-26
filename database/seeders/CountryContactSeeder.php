<?php

namespace Database\Seeders;

use App\Models\CountryContact;
use Illuminate\Database\Seeder;

class CountryContactSeeder extends Seeder
{
    public function run(): void
    {
        // Turkey (default)
        $turkey = CountryContact::updateOrCreate(
            ['country_code' => 'TR'],
            [
                'country_name_ar' => 'تركيا',
                'country_name_en' => 'Turkey',
                'flag_emoji'      => '🇹🇷',
                'phone'           => '+90 212 123 4567',
                'whatsapp'        => '+905551234567',
                'email'           => 'info@grandstart.com',
                'currency_code'   => 'TRY',
                'currency_symbol' => '₺',
                'price_field'     => 'price_try',
                'is_default'      => true,
                'active'          => true,
            ]
        );

        $turkey->addresses()->updateOrCreate(['locale' => 'ar'], ['address' => 'إسطنبول، بيشيكتاش، تركيا']);
        $turkey->addresses()->updateOrCreate(['locale' => 'en'], ['address' => 'Istanbul, Beşiktaş, Turkey']);
        $turkey->addresses()->updateOrCreate(['locale' => 'tr'], ['address' => 'İstanbul, Beşiktaş, Türkiye']);

        // Iraq
        $iraq = CountryContact::updateOrCreate(
            ['country_code' => 'IQ'],
            [
                'country_name_ar' => 'العراق',
                'country_name_en' => 'Iraq',
                'flag_emoji'      => '🇮🇶',
                'phone'           => '+964 750 123 4567',
                'whatsapp'        => '+9647501234567',
                'email'           => 'iraq@grandstart.com',
                'currency_code'   => 'IQD',
                'currency_symbol' => 'د.ع',
                'price_field'     => 'price_iqd',
                'is_default'      => false,
                'active'          => true,
            ]
        );

        $iraq->addresses()->updateOrCreate(['locale' => 'ar'], ['address' => 'بغداد، العراق']);
        $iraq->addresses()->updateOrCreate(['locale' => 'en'], ['address' => 'Baghdad, Iraq']);
        $iraq->addresses()->updateOrCreate(['locale' => 'tr'], ['address' => 'Bağdat, Irak']);

        CountryContact::clearCache();
    }
}

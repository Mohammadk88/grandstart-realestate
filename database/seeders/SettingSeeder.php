<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Company
            ['key' => 'company_name_ar', 'value' => 'جراند ستار للعقارات', 'group' => 'company'],
            ['key' => 'company_name_en', 'value' => 'Grand Start Real Estate', 'group' => 'company'],
            ['key' => 'company_name_tr', 'value' => 'Grand Start Gayrimenkul', 'group' => 'company'],
            ['key' => 'company_tagline_ar', 'value' => 'نحول أحلامك إلى واقع في تركيا', 'group' => 'company'],
            ['key' => 'company_tagline_en', 'value' => 'Turning Your Dreams Into Reality in Turkey', 'group' => 'company'],
            ['key' => 'company_tagline_tr', 'value' => 'Türkiye\'de Hayallerinizi Gerçeğe Dönüştürüyoruz', 'group' => 'company'],
            ['key' => 'company_years', 'value' => '15', 'group' => 'company'],
            ['key' => 'total_clients', 'value' => '1200', 'group' => 'company'],
            ['key' => 'countries_count', 'value' => '8', 'group' => 'company'],

            // Hero
            ['key' => 'hero_title_ar', 'value' => 'اكتشف عقارات فاخرة في تركيا', 'group' => 'hero'],
            ['key' => 'hero_title_en', 'value' => 'Discover Luxury Properties in Turkey', 'group' => 'hero'],
            ['key' => 'hero_title_tr', 'value' => 'Türkiye\'de Lüks Mülkler Keşfedin', 'group' => 'hero'],
            ['key' => 'hero_subtitle_ar', 'value' => 'نقدم لك أفضل المشاريع العقارية في تركيا بأعلى مستويات الجودة والموثوقية', 'group' => 'hero'],
            ['key' => 'hero_subtitle_en', 'value' => 'We offer you the best real estate projects in Turkey with the highest levels of quality and reliability', 'group' => 'hero'],
            ['key' => 'hero_subtitle_tr', 'value' => 'Türkiye\'nin en iyi gayrimenkul projelerini en yüksek kalite ve güvenilirlik standartlarıyla sunuyoruz', 'group' => 'hero'],

            // Contact - Default (Turkey Main Office)
            ['key' => 'phone_default', 'value' => '+90 212 123 4567', 'group' => 'contact'],
            ['key' => 'email_default', 'value' => 'info@grandstartrealestate.com', 'group' => 'contact'],
            ['key' => 'whatsapp_default', 'value' => '+902121234567', 'group' => 'contact'],
            ['key' => 'address_default_ar', 'value' => 'إسطنبول، تركيا - شارع بغداد', 'group' => 'contact'],
            ['key' => 'address_default_en', 'value' => 'Istanbul, Turkey - Baghdad Street', 'group' => 'contact'],
            ['key' => 'address_default_tr', 'value' => 'İstanbul, Türkiye - Bağdat Caddesi', 'group' => 'contact'],

            // Contact - Iraq
            ['key' => 'phone_iraq', 'value' => '+964 750 123 4567', 'group' => 'contact_iraq'],
            ['key' => 'email_iraq', 'value' => 'iraq@grandstartrealestate.com', 'group' => 'contact_iraq'],
            ['key' => 'whatsapp_iraq', 'value' => '+9647501234567', 'group' => 'contact_iraq'],
            ['key' => 'address_iraq_ar', 'value' => 'بغداد، العراق - شارع الكرادة', 'group' => 'contact_iraq'],
            ['key' => 'address_iraq_en', 'value' => 'Baghdad, Iraq - Karada Street', 'group' => 'contact_iraq'],
            ['key' => 'address_iraq_tr', 'value' => 'Bağdat, Irak - Karada Caddesi', 'group' => 'contact_iraq'],

            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/grandstartrealestate', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/grandstartrealestate', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => '', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => '', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => '', 'group' => 'social'],

            // About
            ['key' => 'about_text_ar', 'value' => 'شركة جراند ستار للعقارات متخصصة في تقديم أفضل فرص الاستثمار العقاري في تركيا للعملاء من منطقة الشرق الأوسط والعالم. نؤمن بأن كل عميل يستحق أفضل تجربة عقارية ممكنة، ولهذا نضع معايير عالية الجودة في كل مشروع نقدمه.', 'group' => 'about'],
            ['key' => 'about_text_en', 'value' => 'Grand Start Real Estate specializes in offering the best real estate investment opportunities in Turkey to clients from the Middle East and around the world. We believe every client deserves the best possible real estate experience, which is why we set high quality standards in every project we offer.', 'group' => 'about'],
            ['key' => 'about_text_tr', 'value' => 'Grand Start Gayrimenkul, Orta Doğu ve dünyadan gelen müşterilere Türkiye\'deki en iyi gayrimenkul yatırım fırsatlarını sunma konusunda uzmanlaşmıştır. Her müşterinin mümkün olan en iyi gayrimenkul deneyimini hak ettiğine inanıyoruz.', 'group' => 'about'],

            // SEO
            ['key' => 'meta_title_ar', 'value' => 'جراند ستار للعقارات - عقارات فاخرة في تركيا', 'group' => 'seo'],
            ['key' => 'meta_title_en', 'value' => 'Grand Start Real Estate - Luxury Properties in Turkey', 'group' => 'seo'],
            ['key' => 'meta_title_tr', 'value' => 'Grand Start Gayrimenkul - Türkiye\'de Lüks Mülkler', 'group' => 'seo'],
            ['key' => 'meta_description_ar', 'value' => 'جراند ستار للعقارات - نقدم أفضل المشاريع العقارية الفاخرة في تركيا', 'group' => 'seo'],
            ['key' => 'meta_description_en', 'value' => 'Grand Start Real Estate - The best luxury real estate projects in Turkey', 'group' => 'seo'],
            ['key' => 'meta_description_tr', 'value' => 'Grand Start Gayrimenkul - Türkiye\'nin en iyi lüks gayrimenkul projeleri', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}

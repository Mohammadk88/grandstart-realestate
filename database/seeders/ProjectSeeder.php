<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectFeatureTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug'       => 'bosphorus-luxury-tower',
                'price_usd'  => 380000,
                'price_try'  => 11000000,
                'price_iqd'  => 497000000,
                'area'       => '90-280 م²',
                'floors'     => 40,
                'units'      => 160,
                'status'     => 'available',
                'type'       => 'tower',
                'featured'   => true,
                'active'     => true,
                'sort_order' => 1,
                'translations' => [
                    'ar' => ['title' => 'برج بوسفور الفاخر', 'location' => 'بشيكتاش، إسطنبول', 'description' => 'برج سكني فاخر يتكون من 40 طابقاً بإطلالات خلابة على مضيق البوسفور في إسطنبول. يضم أحدث المرافق والخدمات الفندقية الراقية.'],
                    'en' => ['title' => 'Bosphorus Luxury Tower', 'location' => 'Beşiktaş, Istanbul', 'description' => 'A luxury residential tower of 40 floors with stunning views of the Bosphorus Strait in Istanbul. Features the latest facilities and premium hotel services.'],
                    'tr' => ['title' => 'Boğaz Lüks Kulesi', 'location' => 'Beşiktaş, İstanbul', 'description' => 'İstanbul\'da Boğaz\'a nefes kesen manzarası olan 40 katlı lüks konut kulesi. En son imkânlar ve premium otel hizmetleri sunmaktadır.'],
                ],
                'features' => [
                    ['ar' => 'مسبح مفتوح على السطح', 'en' => 'Rooftop outdoor pool', 'tr' => 'Çatı açık havuzu', 'icon' => 'fas fa-swimming-pool'],
                    ['ar' => 'صالة رياضية مجهزة', 'en' => 'Fully equipped gym', 'tr' => 'Tam donanımlı spor salonu', 'icon' => 'fas fa-dumbbell'],
                    ['ar' => 'حراسة أمنية 24/7', 'en' => '24/7 Security', 'tr' => '24/7 Güvenlik', 'icon' => 'fas fa-shield-alt'],
                    ['ar' => 'موقف سيارات خاص', 'en' => 'Private parking', 'tr' => 'Özel otopark', 'icon' => 'fas fa-parking'],
                    ['ar' => 'إطلالة مباشرة على البوسفور', 'en' => 'Direct Bosphorus view', 'tr' => 'Direkt Boğaz manzarası', 'icon' => 'fas fa-water'],
                    ['ar' => 'خدمات كونسيرج', 'en' => 'Concierge services', 'tr' => 'Konsiyerj hizmetleri', 'icon' => 'fas fa-concierge-bell'],
                ],
            ],
            [
                'slug'       => 'antalya-golden-villa',
                'price_usd'  => 950000,
                'price_try'  => 27500000,
                'price_iqd'  => 1243000000,
                'area'       => '420 م²',
                'floors'     => 2,
                'units'      => 1,
                'status'     => 'available',
                'type'       => 'villa',
                'featured'   => true,
                'active'     => true,
                'sort_order' => 2,
                'translations' => [
                    'ar' => ['title' => 'فيلا أنطاليا الذهبية', 'location' => 'لارا، أنطاليا', 'description' => 'فيلا فاخرة مستقلة على ساحل أنطاليا بحديقة خاصة ومسبح ومطبخ مفتوح. تتميز بالتصميم المعماري العصري المتميز.'],
                    'en' => ['title' => 'Antalya Golden Villa', 'location' => 'Lara, Antalya', 'description' => 'Luxury standalone villa on the Antalya coast with private garden, pool and open kitchen. Features modern contemporary architectural design.'],
                    'tr' => ['title' => 'Antalya Altın Villa', 'location' => 'Lara, Antalya', 'description' => 'Antalya sahilinde özel bahçe, havuz ve açık mutfaklı lüks müstakil villa. Modern çağdaş mimari tasarımıyla öne çıkmaktadır.'],
                ],
                'features' => [
                    ['ar' => '5 غرف نوم', 'en' => '5 Bedrooms', 'tr' => '5 Yatak Odası', 'icon' => 'fas fa-bed'],
                    ['ar' => 'مسبح خاص', 'en' => 'Private pool', 'tr' => 'Özel havuz', 'icon' => 'fas fa-swimming-pool'],
                    ['ar' => 'حديقة 250 م²', 'en' => '250 sqm garden', 'tr' => '250 m² bahçe', 'icon' => 'fas fa-leaf'],
                    ['ar' => 'إطلالة بحرية', 'en' => 'Sea view', 'tr' => 'Deniz manzarası', 'icon' => 'fas fa-water'],
                    ['ar' => 'موقف 3 سيارات', 'en' => '3 Car garage', 'tr' => '3 Araçlık garaj', 'icon' => 'fas fa-car'],
                ],
            ],
            [
                'slug'       => 'istanbul-business-complex',
                'price_usd'  => 220000,
                'price_try'  => 6400000,
                'price_iqd'  => 288000000,
                'area'       => '60-180 م²',
                'floors'     => 15,
                'units'      => 80,
                'status'     => 'under_construction',
                'type'       => 'commercial',
                'featured'   => true,
                'active'     => true,
                'sort_order' => 3,
                'translations' => [
                    'ar' => ['title' => 'مجمع إسطنبول التجاري', 'location' => 'شيشلي، إسطنبول', 'description' => 'مجمع تجاري متكامل يضم مكاتب ومحلات في قلب إسطنبول. استثمار مثالي بعوائد مضمونة.'],
                    'en' => ['title' => 'Istanbul Business Complex', 'location' => 'Şişli, Istanbul', 'description' => 'Integrated commercial complex with offices and retail spaces in the heart of Istanbul. Perfect investment with guaranteed returns.'],
                    'tr' => ['title' => 'İstanbul İş Merkezi Kompleksi', 'location' => 'Şişli, İstanbul', 'description' => 'İstanbul\'un kalbinde ofis ve perakende alanları bulunan entegre ticari kompleks. Garantili getirili mükemmel yatırım.'],
                ],
                'features' => [
                    ['ar' => 'موقع استراتيجي مركزي', 'en' => 'Central strategic location', 'tr' => 'Merkezi stratejik konum', 'icon' => 'fas fa-map-marker-alt'],
                    ['ar' => 'قاعة مؤتمرات حديثة', 'en' => 'Modern conference hall', 'tr' => 'Modern konferans salonu', 'icon' => 'fas fa-users'],
                    ['ar' => 'كافيه ومطعم', 'en' => 'Cafe & restaurant', 'tr' => 'Kafe ve restoran', 'icon' => 'fas fa-coffee'],
                    ['ar' => 'عوائد استثمارية مضمونة', 'en' => 'Guaranteed returns', 'tr' => 'Garantili getiriler', 'icon' => 'fas fa-chart-line'],
                ],
            ],
        ];

        foreach ($projects as $projectData) {
            $translations = $projectData['translations'];
            $features     = $projectData['features'];
            unset($projectData['translations'], $projectData['features']);

            $project = Project::firstOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );

            if ($project->wasRecentlyCreated) {
                foreach ($translations as $locale => $data) {
                    $project->translations()->create([
                        'locale'      => $locale,
                        'title'       => $data['title'],
                        'location'    => $data['location'],
                        'description' => $data['description'],
                    ]);
                }

                foreach ($features as $feature) {
                    $pf = ProjectFeature::create([
                        'project_id' => $project->id,
                        'icon'       => $feature['icon'] ?? 'fas fa-check',
                    ]);

                    foreach (['ar', 'en', 'tr'] as $locale) {
                        if (!empty($feature[$locale])) {
                            ProjectFeatureTranslation::create([
                                'feature_id' => $pf->id,
                                'locale'     => $locale,
                                'text'       => $feature[$locale],
                            ]);
                        }
                    }
                }
            }
        }
    }
}

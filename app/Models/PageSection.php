<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page', 'key', 'label', 'active', 'sort_order'];

    protected $casts = ['active' => 'boolean'];

    public static function getOrdered(string $page = 'home'): \Illuminate\Support\Collection
    {
        return static::where('page', $page)->orderBy('sort_order')->get()->keyBy('key');
    }

    public static function seedDefaults(): void
    {
        $defaults = [
            ['page' => 'home', 'key' => 'hero',        'label' => 'البانر الرئيسي',         'sort_order' => 1],
            ['page' => 'home', 'key' => 'featured',    'label' => 'المشاريع المميزة',        'sort_order' => 2],
            ['page' => 'home', 'key' => 'search_area', 'label' => 'البحث حسب المنطقة',      'sort_order' => 3],
            ['page' => 'home', 'key' => 'why_us',      'label' => 'لماذا نحن',               'sort_order' => 4],
            ['page' => 'home', 'key' => 'about',       'label' => 'من نحن',                  'sort_order' => 5],
            ['page' => 'home', 'key' => 'map',         'label' => 'خريطة المشاريع',          'sort_order' => 6],
            ['page' => 'home', 'key' => 'latest',      'label' => 'أحدث المشاريع',           'sort_order' => 7],
            ['page' => 'home', 'key' => 'cta',         'label' => 'دعوة للتواصل',            'sort_order' => 8],
        ];

        foreach ($defaults as $d) {
            static::firstOrCreate(['key' => $d['key']], $d);
        }
    }
}

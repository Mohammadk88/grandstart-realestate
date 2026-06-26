<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $fillable = [
        'code', 'name_en', 'name_native', 'direction', 'active', 'is_default', 'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }

    public static function allActive(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('languages_active', 600, fn() => static::active()->get());
    }

    public static function codes(): array
    {
        return Cache::remember('language_codes', 600, fn() => static::active()->pluck('code')->all());
    }

    public static function getDefaultCode(): string
    {
        return Cache::remember('language_default_code', 600, function () {
            $lang = static::where('is_default', true)->first()
                ?? static::where('active', true)->orderBy('sort_order')->first();
            return $lang?->code ?? 'ar';
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('languages_active');
        Cache::forget('language_codes');
        Cache::forget('language_default_code');
    }

    public function setAsDefault(): void
    {
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
        static::clearCache();
    }
}

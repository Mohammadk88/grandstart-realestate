<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class CountryContact extends Model
{
    protected $fillable = [
        'country_code', 'country_name_ar', 'country_name_en', 'flag_emoji',
        'phone', 'whatsapp', 'email',
        'currency_code', 'currency_symbol', 'price_field',
        'is_default', 'active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'active' => 'boolean',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(CountryContactAddress::class);
    }

    public function getAddress(string $locale): string
    {
        return $this->addresses->firstWhere('locale', $locale)?->address
            ?? $this->addresses->first()?->address
            ?? '';
    }

    public static function getDefault(): ?self
    {
        return Cache::remember('country_contact_default', 600, function () {
            return static::with('addresses')
                ->where('is_default', true)
                ->where('active', true)
                ->first()
                ?? static::with('addresses')->where('active', true)->first();
        });
    }

    public static function getForCountry(string $countryCode): ?self
    {
        $code = strtoupper($countryCode);
        return Cache::remember("country_contact_{$code}", 600, function () use ($code) {
            return static::with('addresses')
                ->where('country_code', $code)
                ->where('active', true)
                ->first();
        });
    }

    public static function clearCache(?string $countryCode = null): void
    {
        Cache::forget('country_contact_default');
        if ($countryCode) {
            Cache::forget('country_contact_' . strtoupper($countryCode));
        } else {
            // Clear all country caches
            $codes = static::pluck('country_code');
            foreach ($codes as $code) {
                if ($code) Cache::forget('country_contact_' . strtoupper($code));
            }
        }
    }

    public function setAsDefault(): void
    {
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
        static::clearCache();
    }
}

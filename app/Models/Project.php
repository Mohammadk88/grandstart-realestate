<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'price_usd', 'price_try', 'price_iqd',
        'area', 'floors', 'units',
        'status', 'type',
        'featured', 'active',
        'main_image',
        'video_url',
        'latitude', 'longitude',
        'country', 'city', 'district', 'address_detail',
        'delivery_date',
        'sort_order',
    ];

    protected $casts = [
        'featured'  => 'boolean',
        'active'    => 'boolean',
        'price_usd' => 'decimal:2',
        'price_try' => 'decimal:0',
        'price_iqd' => 'decimal:0',
        'delivery_date' => 'date',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order');
    }

    public function mediaImages(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'image')->orderBy('sort_order');
    }

    public function mediaPdfs(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'pdf')->orderBy('sort_order');
    }

    public function mediaVideos(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'video')->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    protected function getTranslation(string $field): string
    {
        $locale = app()->getLocale();
        $default = Language::getDefaultCode();

        $translation = $this->translations->firstWhere('locale', $locale);
        if ($translation && !empty($translation->$field)) {
            return $translation->$field;
        }

        $fallback = $this->translations->firstWhere('locale', $default);
        if ($fallback && !empty($fallback->$field)) {
            return $fallback->$field;
        }

        return $this->translations->first()?->$field ?? '';
    }

    public function getTitle(): string
    {
        return $this->getTranslation('title');
    }

    public function getDescription(): string
    {
        return $this->getTranslation('description');
    }

    public function getLocation(): string
    {
        return $this->getTranslation('location');
    }

    public function getPriceForCountry(string $countryCode = 'TR'): string
    {
        $contact = CountryContact::getForCountry($countryCode) ?? CountryContact::getDefault();
        if (!$contact) {
            return $this->price_usd ? '$' . number_format($this->price_usd, 0) : __('app.price_on_request');
        }

        $field = $contact->price_field;
        $value = $this->$field ?? null;
        if ($value) {
            return $contact->currency_symbol . number_format($value, 0);
        }

        if ($this->price_usd) {
            return '$' . number_format($this->price_usd, 0);
        }

        return __('app.price_on_request');
    }

    public function getMainImageUrl(): string
    {
        if ($this->main_image) {
            return asset('uploads/' . $this->main_image);
        }
        return asset('images/project-placeholder.svg');
    }

    public function getMainImageThumbUrl(): string
    {
        if ($this->main_image) {
            $thumb = preg_replace('/(\.\w+)$/', '_thumb$1', $this->main_image);
            $thumbPath = storage_path('app/public/' . $thumb);
            if (file_exists($thumbPath)) {
                return asset('uploads/' . $thumb);
            }
            return asset('uploads/' . $this->main_image);
        }
        return asset('images/project-placeholder.svg');
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'available'          => __('app.available'),
            'sold_out'           => __('app.sold_out'),
            'under_construction' => __('app.under_construction'),
            'coming_soon'        => __('app.coming_soon'),
            default              => __('app.available'),
        };
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'residential' => __('app.residential'),
            'commercial'  => __('app.commercial'),
            'villa'       => __('app.villa'),
            'apartment'   => __('app.apartment'),
            'compound'    => __('app.compound'),
            'tower'       => __('app.tower'),
            default       => __('app.residential'),
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug('project') . '-' . Str::random(8);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}

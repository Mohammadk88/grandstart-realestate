<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image', 'title_ar', 'title_en', 'title_tr',
        'subtitle_ar', 'subtitle_en', 'subtitle_tr',
        'btn_label_ar', 'btn_label_en', 'btn_label_tr',
        'btn_url', 'active', 'sort_order',
    ];

    protected $casts = ['active' => 'boolean'];

    public static function active()
    {
        return static::where('active', true)->orderBy('sort_order')->get();
    }

    public function getTitle(): string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_ar ?? '';
    }

    public function getSubtitle(): string
    {
        $locale = app()->getLocale();
        return $this->{"subtitle_{$locale}"} ?? $this->subtitle_ar ?? '';
    }

    public function getBtnLabel(): string
    {
        $locale = app()->getLocale();
        return $this->{"btn_label_{$locale}"} ?? $this->btn_label_ar ?? '';
    }

    public function getImageUrl(): string
    {
        return asset('uploads/' . $this->image);
    }
}

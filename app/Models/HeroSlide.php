<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $guarded = ['id'];

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

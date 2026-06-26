<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectFeature extends Model
{
    protected $fillable = ['project_id', 'icon'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectFeatureTranslation::class, 'feature_id');
    }

    public function getLabel(): string
    {
        $locale = app()->getLocale();
        $default = Language::getDefaultCode();

        $translation = $this->translations->firstWhere('locale', $locale);
        if ($translation && !empty($translation->text)) {
            return $translation->text;
        }

        $fallback = $this->translations->firstWhere('locale', $default);
        if ($fallback && !empty($fallback->text)) {
            return $fallback->text;
        }

        return $this->translations->first()?->text ?? '';
    }
}

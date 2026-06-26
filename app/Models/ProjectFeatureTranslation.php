<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFeatureTranslation extends Model
{
    protected $fillable = ['feature_id', 'locale', 'text'];

    public function feature(): BelongsTo
    {
        return $this->belongsTo(ProjectFeature::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = ['project_id', 'image', 'caption_ar', 'caption_en', 'sort_order'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getUrl(): string
    {
        return asset('uploads/' . $this->image);
    }
}

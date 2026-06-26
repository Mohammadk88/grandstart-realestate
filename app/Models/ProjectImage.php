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

    public function getThumbUrl(): string
    {
        $thumb = preg_replace('/(\.\w+)$/', '_thumb$1', $this->image);
        $thumbPath = storage_path('app/public/' . $thumb);
        if (file_exists($thumbPath)) {
            return asset('uploads/' . $thumb);
        }
        return asset('uploads/' . $this->image);
    }
}

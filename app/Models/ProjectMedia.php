<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    protected $fillable = [
        'project_id', 'type', 'path', 'thumbnail',
        'original_name', 'file_size', 'caption_ar', 'caption_en', 'sort_order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getUrl(): string
    {
        return asset('uploads/' . $this->path);
    }

    public function getThumbUrl(): string
    {
        if ($this->thumbnail && file_exists(storage_path('app/public/' . $this->thumbnail))) {
            return asset('uploads/' . $this->thumbnail);
        }
        return match($this->type) {
            'pdf'   => asset('images/pdf-icon.png'),
            'video' => asset('images/video-thumb.jpg'),
            default => asset('uploads/' . $this->path),
        };
    }

    public function isImage(): bool { return $this->type === 'image'; }
    public function isPdf(): bool   { return $this->type === 'pdf'; }
    public function isVideo(): bool { return $this->type === 'video'; }

    public function getFileSizeFormatted(): string
    {
        if (!$this->file_size) return '';
        $kb = $this->file_size / 1024;
        if ($kb < 1024) return round($kb, 1) . ' KB';
        return round($kb / 1024, 1) . ' MB';
    }
}

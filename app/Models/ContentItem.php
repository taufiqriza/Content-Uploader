<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    protected $fillable = [
        'organization_id',
        'media_asset_id',
        'user_id',
        'title',
        'caption',
        'content_type',
        'status',
        'scheduled_at',
        'published_at',
        'target_platforms',
        'media_path',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'target_platforms' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->organization_id) {
                $model->organization_id = auth()->user()->organization_id ?? 1;
            }
            if (!$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function mediaAsset()
    {
        return $this->belongsTo(MediaAsset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function platformPosts()
    {
        return $this->hasMany(PlatformPost::class);
    }

    public function isReadyToPublish(): bool
    {
        return in_array($this->status, ['approved', 'scheduling']);
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['done', 'partial_fail', 'failed']);
    }
}

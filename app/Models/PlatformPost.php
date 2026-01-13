<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlatformPost extends Model
{
    use Auditable;
    protected $fillable = [
        'content_item_id',
        'social_account_id',
        'status',
        'external_post_id',
        'external_url',
        'error_message',
        'attempt_count',
        'last_attempt_at',
        'published_at',
        'idempotency_key',
    ];

    protected $casts = [
        'last_attempt_at' => 'datetime',
        'published_at' => 'datetime',
        'attempt_count' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            if (!$post->idempotency_key) {
                $post->idempotency_key = Str::uuid()->toString();
            }
        });
    }

    public function contentItem()
    {
        return $this->belongsTo(ContentItem::class);
    }

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }

    public function canRetry(): bool
    {
        return $this->status === 'failed' && $this->attempt_count < 3;
    }

    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',
            'attempt_count' => $this->attempt_count + 1,
            'last_attempt_at' => now(),
        ]);
    }

    public function markAsPublished(string $externalId, string $externalUrl): void
    {
        $this->update([
            'status' => 'published',
            'external_post_id' => $externalId,
            'external_url' => $externalUrl,
            'published_at' => now(),
            'error_message' => null,
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }
}

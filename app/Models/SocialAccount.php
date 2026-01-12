<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'organization_id',
        'platform',
        'platform_user_id',
        'name',
        'avatar_url',
        'enc_access_token',
        'enc_refresh_token',
        'token_expires_at',
        'scopes',
        'is_active',
    ];

    protected $casts = [
        'enc_access_token' => 'encrypted',
        'enc_refresh_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'scopes' => 'array',
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'enc_access_token',
        'enc_refresh_token',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function platformPosts()
    {
        return $this->hasMany(PlatformPost::class);
    }

    public function isTokenExpired(): bool
    {
        if (!$this->token_expires_at) {
            return false;
        }
        return $this->token_expires_at->isPast();
    }
}

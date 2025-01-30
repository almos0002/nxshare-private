<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccessToken extends Model
{
    protected $fillable = ['token', 'access_type', 'post_id', 'ip_address', 'expires_at'];
    protected $dates = ['expires_at'];

    public static function generateToken($accessType, $postId, $ip)
    {
        // Cleanup expired tokens
        self::expired()->delete();

        // Check existing valid token
        $existing = self::validToken($accessType, $postId, $ip)->first();
        if ($existing) return $existing->token;

        // Create new token
        return self::create([
            'token' => Str::random(64),
            'access_type' => $accessType,
            'post_id' => $postId,
            'ip_address' => $ip,
            'expires_at' => now()->addHours(12),
        ])->token;
    }

    public static function isValid($token, $accessType, $postId, $ip)
    {
        return self::validToken($accessType, $postId, $ip)
            ->where('token', $token)
            ->exists();
    }

    // Scopes
    public function scopeValidToken($query, $accessType, $postId, $ip)
    {
        return $query->where('access_type', $accessType)
            ->where('post_id', $postId)
            ->where('ip_address', $ip)
            ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
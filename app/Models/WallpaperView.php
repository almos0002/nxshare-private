<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WallpaperView extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'ip_address',
    ];

    public function post()
    {
        return $this->belongsTo(Wallpaper::class);
    }
}
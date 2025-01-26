<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallpaper extends Model
{
    protected $table = "wallpaper";

    // Fillable Columns
    protected $fillable = ['title', 'links', 'slug', 'views'];

    protected $casts = [
        'links' => 'array',
    ];
}

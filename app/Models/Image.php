<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "images";

    // Fillable Columns
    protected $fillable = ['title', 'links', 'slug', 'views'];

    protected $casts = [
        'links' => 'array',
    ];
}

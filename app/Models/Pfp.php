<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pfp extends Model
{
    protected $table = "pfp";

    // Fillable Columns
    protected $fillable = ['title', 'links', 'slug', 'views'];

    protected $casts = [
        'links' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "videos";

    // Fillable Columns
    protected $fillable = ['title', 'thumbnail', 'links', 'slug', 'views'];

}

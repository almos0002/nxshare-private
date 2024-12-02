<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nxleak extends Model
{
    protected $table = "nxleak";

    // Fillable Columns
    protected $fillable = ['title', 'content', 'slug', 'views'];
}

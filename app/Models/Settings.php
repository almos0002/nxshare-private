<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = "settings";

    // Fillable Columns
    protected $fillable = ['active_domain', 'redirect_enabled','ad1', 'ad2'];
}

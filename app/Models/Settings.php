<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Settings extends Model
{
    protected $table = "settings";

    // Fillable Columns
    protected $fillable = ['active_domain', 'redirect_enabled','ad1', 'ad2', 'nsfw', 'user_id'];
    
    /**
     * Get the user that owns the settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

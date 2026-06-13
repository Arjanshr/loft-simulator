<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    protected $fillable = ['loft_id', 'pigeon_id', 'price', 'is_active'];

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }

    public function pigeon(): BelongsTo
    {
        return $this->belongsTo(Pigeon::class);
    }
}

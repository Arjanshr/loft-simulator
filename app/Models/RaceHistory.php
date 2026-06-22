<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RaceHistory extends Model
{
    protected $fillable = [
        'loft_id',
        'race_title',
        'race_type',
        'pigeon_name',
        'position',
        'payout',
    ];

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }
}

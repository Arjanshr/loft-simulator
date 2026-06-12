<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pigeon extends Model
{
    protected $fillable = [
        'loft_id',
        'name',
        'speed',
        'endurance',
        'navigation',
        'temperament',
        'energy',
        'status',
        'last_trained_at',
    ];

    protected $casts = [
        'last_trained_at' => 'datetime',
    ];

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }
}

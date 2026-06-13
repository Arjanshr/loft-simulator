<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreedingRecord extends Model
{
    protected $fillable = ['loft_id', 'sire_id', 'dam_id', 'eggs_laid_at'];

    protected $casts = [
        'eggs_laid_at' => 'datetime',
    ];

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }
}

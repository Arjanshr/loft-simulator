<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Pair extends Model
{
    protected $fillable = ['loft_id', 'male_id', 'female_id', 'is_active'];

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }

    public function male(): BelongsTo
    {
        return $this->belongsTo(Pigeon::class, 'male_id');
    }

    public function female(): BelongsTo
    {
        return $this->belongsTo(Pigeon::class, 'female_id');
    }
}

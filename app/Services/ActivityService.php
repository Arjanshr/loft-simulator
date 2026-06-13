<?php

namespace App\Services;

use App\Models\Loft;
use App\Models\ActivityLog;

class ActivityService
{
    public function log(Loft $loft, string $description): void
    {
        ActivityLog::create([
            'loft_id' => $loft->id,
            'description' => $description,
            'created_at' => now(),
        ]);
    }
}

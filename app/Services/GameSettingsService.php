<?php

namespace App\Services;

use App\Models\GameSetting;
use Illuminate\Support\Facades\Cache;

class GameSettingsService
{
    public function get(string $key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = GameSetting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public function set(string $key, $value): void
    {
        GameSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting_' . $key);
    }
}

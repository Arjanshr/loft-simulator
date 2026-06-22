<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Feature Unlock Levels
    |--------------------------------------------------------------------------
    */
    'unlock_levels' => [
        'training' => 2,
        'marketplace' => 10,
        'breeding' => 15,
    ],

    /*
    |--------------------------------------------------------------------------
    | Training Settings
    |--------------------------------------------------------------------------
    */
    'training' => [
        'energy_cost' => 20,
        'base_coin_cost' => 100,
        'beauty_multiplier' => 10,
        'stat_threshold_multiplier' => 10, // level * 10
        'intelligence_divisor' => 20,
        'level_gain_multiplier' => 1.5,
        'rest_cost' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pigeon Progression
    |--------------------------------------------------------------------------
    */
    'pigeons' => [
        'level_up_stat_multiplier' => 30, // level * 30
        'level_up_reward_base' => 100,
        'max_level' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Aesthetic Improvements
    |--------------------------------------------------------------------------
    */
    'aesthetics' => [
        'base_cost' => 50,
        'cost_exponent' => 1.15,
        'max_value' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketplace Settings
    |--------------------------------------------------------------------------
    */
    'marketplace' => [
        'listing_duration_hours' => 24,
        'sell_price_multiplier' => 500, // level * 500
        'sell_price_intelligence_bonus' => 10, // intelligence * 10
        'visibility_level_diff' => 1, // Loft Level + 1
        'visibility_chance' => 0.05, // 5% chance for higher level pigeons
    ],
];

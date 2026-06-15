<?php

return [
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
];

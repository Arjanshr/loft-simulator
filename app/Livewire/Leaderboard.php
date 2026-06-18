<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pigeon;
use App\Models\Loft;

class Leaderboard extends Component
{
    public $filter = 'overall'; // overall, fancy, racer, highflyer

    public function render()
    {
        $query = Pigeon::query()->whereHas('loft.user', function ($q) {
            $q->where('is_ai', false);
        });

        if ($this->filter !== 'overall') {
            $query->where('type', $this->filter);
        }

        // Top pigeons by total score (unchanged)
        $topPigeons = $query->with('loft')->get()->sortByDesc('total_score')->values()->take(10);

        // Most expensive pigeon (by accessor fixed_price)
        $mostExpensivePigeon = $query->with('loft')->get()->sortByDesc(function ($p) {
            return $p->fixed_price;
        })->first();

        // Top lofts by prestige score (existing logic)
        $topLofts = Loft::whereHas('user', function ($q) {
            $q->where('is_ai', false);
        })->get()->map(function ($loft) {
            return [
                'name' => $loft->name,
                'level' => $loft->level,
                'score' => $loft->pigeons->sum('total_score'),
            ];
        })->sortByDesc('score')->values()->take(10);

        // Most valuable lofts by total fixed_price value of its pigeons
        $topValuableLofts = Loft::whereHas('user', function ($q) {
            $q->where('is_ai', false);
        })->with('pigeons')->get()->map(function ($loft) {
            return [
                'name' => $loft->name,
                'level' => $loft->level,
                'value' => $loft->pigeons->sum('fixed_price'),
            ];
        })->sortByDesc('value')->values()->take(10);

        return view('livewire.leaderboard', [
            'topPigeons' => $topPigeons,
            'mostExpensivePigeon' => $mostExpensivePigeon,
            'topLofts' => $topLofts,
            'topValuableLofts' => $topValuableLofts,
        ]);
    }
}

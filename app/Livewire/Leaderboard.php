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

        $topPigeons = $query->with('loft')->get()->sortByDesc('total_score')->values()->take(10);
        
        $topLofts = Loft::whereHas('user', function ($q) {
            $q->where('is_ai', false);
        })->get()->map(function ($loft) {
            return [
                'name' => $loft->name,
                'level' => $loft->level,
                'score' => $loft->pigeons->sum('total_score'),
            ];
        })->sortByDesc('score')->values()->take(10);

        return view('livewire.leaderboard', [
            'topPigeons' => $topPigeons,
            'topLofts' => $topLofts,
        ]);
    }
}

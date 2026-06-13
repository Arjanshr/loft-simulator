<div class="max-w-2xl mx-auto p-6" wire:init="startSimulation">
    <div class="bg-slate-900 rounded-2xl shadow-xl overflow-hidden border border-slate-700">
        <div class="bg-yellow-500 p-8 text-black text-center">
            <h2 class="text-3xl font-black italic uppercase tracking-widest">{{ $race->title }}</h2>
            <p class="text-black/70 mt-2 font-bold uppercase">{{ $race->race_type }} Tournament</p>
        </div>

        <div class="p-8">
            @if($isSimulating)
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-bounce mb-4 text-4xl">🕊️</div>
                    <div class="w-full bg-slate-800 rounded-full h-2 max-w-xs overflow-hidden">
                        <div class="bg-yellow-500 h-full animate-progress-indefinite"></div>
                    </div>
                    <p class="mt-4 text-slate-400 font-medium">
                        @if($race->race_type == 'exhibition') Judging aesthetics...
                        @elseif($race->race_type == 'highflyer') Measuring endurance...
                        @else Calculating speed... @endif
                    </p>
                </div>
            @else
                <div class="space-y-4">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-white">
                        🏁 Official Results
                    </h3>

                    @foreach($results as $result)
                        <div class="flex items-center gap-4 p-4 rounded-xl border {{ $result->pigeon_id == $pigeonId ? 'border-yellow-500 bg-slate-800' : 'bg-slate-950 border-slate-700' }}">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full font-black {{ $result->position <= 3 ? 'bg-yellow-500 text-black' : 'bg-slate-700 text-slate-400' }}">
                                {{ $result->position }}
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-white">{{ $result->pigeon->name }}</span>
                                <span class="text-xs text-slate-400 block">
                                    @if($race->race_type == 'exhibition') Beauty Score: {{ number_format($result->pigeon->beauty, 2) }}
                                    @else Time: {{ gmdate("H:i:s", $result->finish_time_seconds) }} @endif
                                </span>
                            </div>
                            @if($result->payout > 0)
                                <div class="text-green-400 font-black">
                                    +💰{{ number_format($result->payout) }}
                                </div>
                            @endif
                            @if($result->pigeon_id == $pigeonId)
                                <div class="bg-yellow-500 text-black text-[10px] px-2 py-1 rounded-full font-bold uppercase">YOU</div>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-8 pt-6 border-t border-slate-700 flex justify-center">
                        <a href="{{ route('dashboard') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-8 py-3 rounded-full font-bold transition">
                            Return to Loft
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes progress-indefinite {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-progress-indefinite {
            width: 100%;
            animation: progress-indefinite 2s linear infinite;
        }
    </style>
</div>

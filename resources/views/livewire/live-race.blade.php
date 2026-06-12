<div class="max-w-2xl mx-auto p-6" wire:init="startSimulation">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-indigo-700 p-8 text-white text-center">
            <h2 class="text-3xl font-black italic uppercase tracking-widest">Live Race</h2>
            <p class="text-indigo-200 mt-2">The pigeons are in the air!</p>
        </div>

        <div class="p-8">
            @if($isSimulating)
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-bounce mb-4 text-4xl">🕊️</div>
                    <div class="w-full bg-gray-200 rounded-full h-2 max-w-xs overflow-hidden">
                        <div class="bg-indigo-600 h-full animate-progress-indefinite"></div>
                    </div>
                    <p class="mt-4 text-gray-500 font-medium">Calculating wind speed and navigation patterns...</p>
                </div>
            @else
                <div class="space-y-4">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        🏁 Official Results
                    </h3>

                    @foreach($results as $result)
                        <div class="flex items-center gap-4 p-4 rounded-xl border {{ $result->pigeon_id == $pigeonId ? 'border-indigo-500 bg-indigo-50' : 'bg-gray-50 border-gray-100' }}">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full font-black {{ $result->position <= 3 ? 'bg-yellow-400 text-yellow-900' : 'bg-gray-200 text-gray-600' }}">
                                {{ $result->position }}
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-gray-800">{{ $result->pigeon->name }}</span>
                                <span class="text-xs text-gray-400 block">{{ gmdate("H:i:s", $result->finish_time_seconds) }}</span>
                            </div>
                            @if($result->payout > 0)
                                <div class="text-green-600 font-black">
                                    +💰{{ number_format($result->payout) }}
                                </div>
                            @endif
                            @if($result->pigeon_id == $pigeonId)
                                <div class="bg-indigo-600 text-white text-[10px] px-2 py-1 rounded-full font-bold uppercase">YOU</div>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-8 pt-6 border-t flex justify-center">
                        <a href="{{ route('dashboard') }}" class="bg-gray-800 hover:bg-black text-white px-8 py-3 rounded-full font-bold transition">
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

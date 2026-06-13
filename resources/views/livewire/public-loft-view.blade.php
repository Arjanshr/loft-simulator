<div class="p-6 max-w-7xl mx-auto text-slate-200">
    <div class="bg-yellow-500 text-black p-8 rounded-3xl shadow-2xl mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black">{{ $loft->name }}</h1>
            <p class="text-black/70 font-bold mt-1">Owner: <span class="text-black">{{ $loft->user->name }}</span> | Level: {{ $loft->level }}</p>
        </div>
        <div class="text-center">
            <div class="text-4xl font-black text-black">🕊️</div>
            <div class="text-xs uppercase tracking-widest text-black/70 font-bold">Loft</div>
        </div>
    </div>

    <h2 class="text-2xl font-black text-white mb-6">Pigeon Collection</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($loft->pigeons as $pigeon)
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-700 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg text-white">{{ $pigeon->name }} <span class="text-xs text-yellow-500 font-bold ml-1">Lv.{{ $pigeon->level }}</span></h3>
                        <div class="flex gap-2 mt-1">
                            <span class="text-[10px] bg-slate-700 px-2 py-0.5 rounded uppercase text-slate-300">{{ $pigeon->type }}</span>
                            <span class="text-[10px] bg-indigo-500 px-2 py-0.5 rounded uppercase text-white">{{ ucfirst($pigeon->gender) }}</span>
                            <span class="text-[10px] bg-yellow-600/20 text-yellow-500 px-2 py-0.5 rounded uppercase">{{ $pigeon->rarity }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-[10px] mb-4">
                    <div class="bg-slate-800 p-1 rounded text-slate-400">🏃 Spd: <span class="text-white">{{ $pigeon->speed }}</span></div>
                    <div class="bg-slate-800 p-1 rounded text-slate-400">🔋 End: <span class="text-white">{{ $pigeon->endurance }}</span></div>
                    <div class="bg-slate-800 p-1 rounded text-slate-400">🧭 Nav: <span class="text-white">{{ $pigeon->navigation }}</span></div>
                    <div class="bg-slate-800 p-1 rounded text-slate-400">🧘 Temp: <span class="text-white">{{ $pigeon->temperament }}</span></div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-[9px] mb-4 text-slate-300">
                    <div>👁️ Eyes: {{ $pigeon->eyes }}</div>
                    <div>👃 Beak: {{ $pigeon->beak }}</div>
                    <div>🦵 Legs: {{ $pigeon->legs }}</div>
                    <div>✨ Qual: {{ $pigeon->feather_quality }}</div>
                    <div>🎨 Patt: {{ $pigeon->pattern }}</div>
                    <div>🌈 Color: {{ $pigeon->color }}</div>
                    <div>💎 Purity: {{ $pigeon->purity }}</div>
                </div>

                <div class="pt-4 border-t border-slate-700 text-xs font-bold text-yellow-500">
                    Beauty Score: {{ number_format($pigeon->beauty, 2) }}
                </div>
            </div>
        @endforeach
    </div>
</div>

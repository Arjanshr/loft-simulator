<div class="p-6 md:p-12 max-w-7xl mx-auto font-sans text-slate-300">
    <!-- Loft Header -->
    <div class="bg-[#050a0a] p-10 md:p-12 rounded-[3rem] shadow-2xl mb-12 border-2 border-[#b8860b]/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">Loft</div>
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 relative z-10">
            <div>
                <h1 class="text-4xl md:text-5xl font-industrial font-black text-white italic uppercase tracking-tighter mb-3">{{ $loft->name }}</h1>
                <p class="text-[10px] font-black text-[#b8860b] uppercase tracking-[0.4em] italic">Proprietor: <span class="text-white">{{ $loft->user->name }}</span> | Loft Level: {{ $loft->level }}</p>
            </div>
            <div class="text-center bg-black/40 px-8 py-4 rounded-2xl border border-white/5">
                <div class="text-5xl font-black mb-1">🕊️</div>
                <div class="text-[8px] font-black text-slate-500 uppercase tracking-widest italic">Registered Loft</div>
            </div>
        </div>
    </div>

    <!-- Collection Header -->
    <h2 class="text-2xl md:text-3xl font-industrial font-black text-white mb-10 italic uppercase tracking-widest flex items-center gap-4">
        <span class="w-8 h-1 bg-[#b8860b] rounded-full"></span> Bird Registry
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($loft->pigeons as $pigeon)
            <div class="bg-[#050a0a] p-8 rounded-[2rem] border-2 border-[#b8860b]/10 shadow-xl hover:border-[#b8860b]/30 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-industrial font-black text-xl text-white italic uppercase tracking-tighter">{{ $pigeon->name }}</h3>
                        <span class="text-[9px] text-[#b8860b] font-black tracking-widest uppercase italic">LV.{{ $pigeon->level }}</span>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="text-[8px] bg-black/40 px-3 py-1 rounded-full uppercase text-slate-400 font-bold tracking-widest">{{ $pigeon->type }} Strain</span>
                            <span class="text-[8px] bg-indigo-900/20 px-3 py-1 rounded-full uppercase text-indigo-400 font-bold tracking-widest">{{ ucfirst($pigeon->gender) }}</span>
                            <span class="text-[8px] bg-[#b8860b]/10 px-3 py-1 rounded-full uppercase text-[#b8860b] font-bold tracking-widest">{{ $pigeon->rarity }} Heritage</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-[9px] mb-6 font-black uppercase tracking-widest text-slate-500 italic bg-black/30 p-4 rounded-xl border border-white/5">
                    <div>Speed: <span class="text-white">{{ $pigeon->speed }}</span></div>
                    <div>Endurance: <span class="text-white">{{ $pigeon->endurance }}</span></div>
                    <div>Navigation: <span class="text-white">{{ $pigeon->navigation }}</span></div>
                    <div>Temperament: <span class="text-white">{{ $pigeon->temperament }}</span></div>
                </div>

                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-[8px] mb-6 text-slate-400 italic">
                    <div>👁️ Eyes: {{ $pigeon->eyes }}</div>
                    <div>👃 Beak: {{ $pigeon->beak }}</div>
                    <div>🦵 Legs: {{ $pigeon->legs }}</div>
                    <div>✨ Feathering: {{ $pigeon->feather_quality }}</div>
                    <div>🎨 Pattern: {{ $pigeon->pattern }}</div>
                    <div>🌈 Color: {{ $pigeon->color }}</div>
                    <div>💎 Bloodline: {{ $pigeon->purity }}</div>
                </div>

                <div class="pt-6 border-t border-white/5 text-[10px] font-black text-[#b8860b] uppercase tracking-[0.2em] italic">
                    Appearance Score: {{ number_format($pigeon->beauty, 2) }}
                </div>
            </div>
        @endforeach
    </div>
</div>

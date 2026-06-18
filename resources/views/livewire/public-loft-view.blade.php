<div class="p-4 md:p-12 max-w-7xl mx-auto font-sans text-slate-300">
    <!-- Loft Header: The Official Plaque -->
    <div class="parchment-panel p-8 md:p-16 rounded-[3rem] shadow-2xl mb-12 border-2 border-aviary-brass/10 relative overflow-hidden galvanized-border">
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] text-6xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Loft</div>
        <div class="absolute inset-0 bg-gradient-to-br from-aviary-brass/5 to-transparent pointer-events-none"></div>
        
        <div class="flex flex-col sm:flex-row justify-between items-center gap-10 relative z-10">
            <div class="text-center sm:text-left">
                <span class="text-[10px] md:text-xs font-black text-aviary-brass uppercase tracking-[0.5em] mb-4 block italic">Verified Registry</span>
                <h1 class="text-4xl md:text-7xl font-industrial font-black text-white italic uppercase tracking-tighter leading-none mb-4 drop-shadow-lg">{{ $loft->name }}</h1>
                <p class="text-[10px] md:text-sm font-black text-aviary-feather/40 uppercase tracking-[0.3em] italic">Proprietor: <span class="text-white">{{ $loft->user->name }}</span> <span class="mx-3 text-aviary-brass/20">|</span> Registry Grade {{ $loft->level }}</p>
            </div>
            <div class="text-center bg-aviary-oak/60 px-10 py-6 rounded-[2rem] border border-aviary-brass/10 shadow-inner">
                <div class="text-6xl font-black mb-3 drop-shadow-sm">🕊️</div>
                <div class="text-[9px] font-black text-aviary-brass uppercase tracking-widest italic">Authorized Loft</div>
            </div>
        </div>
    </div>

    <!-- Collection Header -->
    <div class="flex items-center gap-6 mb-12 px-4">
        <div class="w-1.5 h-8 bg-aviary-blue rounded-full shadow-[0_0_10px_#3b82f6]"></div>
        <h2 class="text-2xl md:text-4xl font-industrial font-black text-white italic uppercase tracking-widest">Specimen Registry</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($loft->pigeons as $pigeon)
            <div class="parchment-panel p-8 rounded-[2.5rem] border-2 border-aviary-brass/10 shadow-xl hover:border-aviary-blue/30 transition-all duration-500 overflow-hidden relative group galvanized-border">
                <div class="absolute top-0 right-0 p-6 opacity-[0.02] text-4xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Registry</div>
                
                <div class="flex justify-between items-start mb-8 relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-aviary-blue text-white font-industrial font-black text-[10px] px-3 py-0.5 rounded italic shadow-lg">LV.{{ $pigeon->level }}</span>
                            <h3 class="font-industrial font-black text-xl text-white italic uppercase tracking-tighter leading-none">{{ $pigeon->name }}</h3>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4">
                            <span class="text-[9px] bg-black/40 px-3 py-1 rounded-full uppercase text-aviary-feather/40 font-mono font-bold tracking-widest border border-white/5">{{ $pigeon->type }}</span>
                            <span class="text-[9px] {{ $pigeon->gender == 'male' ? 'bg-aviary-blue/10 text-aviary-blue border-aviary-blue/10' : 'bg-aviary-rose/10 text-aviary-rose border-aviary-rose/10' }} px-3 py-1 rounded-full uppercase font-mono font-bold tracking-widest border">{{ $pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}</span>
                            @php
                                $rarityClass = match($pigeon->rarity) {
                                    'mythic'     => 'bg-purple-900/40 text-purple-300 border-purple-500/30',
                                    'legendary'  => 'bg-yellow-900/40 text-yellow-300 border-yellow-500/30',
                                    'super_rare' => 'bg-blue-900/40 text-blue-300 border-blue-500/30',
                                    'rare'       => 'bg-green-900/40 text-green-300 border-green-500/30',
                                    default      => 'bg-black/40 text-aviary-feather/40 border-white/5',
                                };
                            @endphp
                            <span class="text-[9px] {{ $rarityClass }} px-3 py-1 rounded-full uppercase font-mono font-bold tracking-widest border">{{ strtoupper(str_replace('_', ' ', $pigeon->rarity)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Performance matrix -->
                <div class="grid grid-cols-2 gap-4 text-[9px] mb-8 font-mono font-bold uppercase tracking-widest text-aviary-feather/30 italic bg-black/30 p-5 rounded-2xl border border-aviary-brass/5 shadow-inner group-hover:border-aviary-blue/20 transition-all">
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>SPD:</span> <span class="text-white">{{ $pigeon->speed }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>END:</span> <span class="text-white">{{ $pigeon->endurance }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>NAV:</span> <span class="text-white">{{ $pigeon->navigation }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>TMP:</span> <span class="text-white">{{ $pigeon->temperament }}</span></div>
                </div>

                <!-- Technical log -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-[9px] mb-8 text-aviary-feather/40 italic font-mono">
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>EYE</span> <span class="text-white/60">{{ number_format($pigeon->eyes, 1) }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>BEK</span> <span class="text-white/60">{{ number_format($pigeon->beak, 1) }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>LEG</span> <span class="text-white/60">{{ number_format($pigeon->legs, 1) }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>FTH</span> <span class="text-white/60">{{ number_format($pigeon->feather_quality, 1) }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>PAT</span> <span class="text-white/60">{{ number_format($pigeon->pattern, 1) }}</span></div>
                    <div class="flex justify-between border-b border-white/5 pb-1"><span>CLR</span> <span class="text-white/60">{{ number_format($pigeon->color, 1) }}</span></div>
                </div>

                <div class="pt-6 border-t border-aviary-brass/10 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-aviary-brass uppercase tracking-[0.2em] italic">Standard Score</span>
                        <span class="text-2xl font-industrial font-black text-aviary-brass trophy-gold italic">{{ number_format($pigeon->beauty, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-black/30 px-4 py-2 rounded-xl border border-aviary-brass/10">
                        <span class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest italic">Est. Value</span>
                        <span class="font-mono font-bold text-aviary-brass text-sm">{{ number_format($pigeon->fixed_price, 2) }} 💰</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="text-slate-300 font-sans">
    @if (session()->has('race_error'))
        <div class="p-6 bg-red-900/20 border border-red-500/30 rounded-2xl mb-10 animate-pulse text-center">
            <p class="text-sm text-red-400 font-black uppercase tracking-widest italic">⚠ {{ session('race_error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Left: Bird Selection -->
        <div class="lg:col-span-1 space-y-8 bg-[#050a0a] p-8 rounded-[2.5rem] border-2 border-white/5 shadow-2xl">
            <div class="flex items-center gap-3 mb-2">
                <div class="h-4 w-1 bg-[#b8860b]"></div>
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] italic">Assign Bird</h3>
            </div>
            
            <div class="relative group">
                <select wire:model="selectedPigeonId" 
                        class="w-full bg-black/40 border-2 border-[#b8860b]/20 rounded-2xl p-5 text-white font-bold focus:border-[#b8860b] transition-all appearance-none cursor-pointer italic uppercase text-sm">
                    <option value="">SELECT READY BIRD</option>
                    @foreach($readyPigeons as $p)
                        <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }} - {{ strtoupper($p->type) }}]</option>
                    @endforeach
                </select>
                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-[#b8860b]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest italic leading-relaxed">Only birds with >50% condition are eligible for competition entry.</p>
        </div>

        <!-- Right: Tournament List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-4 w-1 bg-[#b8860b]"></div>
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] italic">Racing Fields</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                @foreach($races as $race)
                    <div class="group bg-[#050a0a] border-2 border-white/5 rounded-[2.5rem] p-6 md:p-8 hover:border-[#b8860b]/40 transition-all duration-500 shadow-xl flex flex-col md:flex-row justify-between items-center gap-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-1 h-full bg-[#b8860b]/10 group-hover:bg-[#b8860b] transition-all"></div>
                        
                        <div class="flex-1 relative z-10">
                            <div class="flex items-center gap-4 mb-3">
                                <span class="text-[9px] font-black bg-[#b8860b]/20 text-[#b8860b] px-3 py-1 rounded-lg italic uppercase border border-[#b8860b]/20 tracking-tighter">{{ $race->race_type }}</span>
                                <h4 class="text-2xl md:text-3xl font-industrial font-black text-white italic tracking-tighter uppercase leading-none">{{ $race->title }}</h4>
                            </div>
                            <div class="flex flex-wrap gap-6 text-[10px] font-black text-slate-500 uppercase tracking-widest italic">
                                <span class="flex items-center gap-2">🏁 {{ $race->distance_km }}KM COURSE</span>
                                <span class="flex items-center gap-2">🎖️ MIN LV.{{ $race->level_requirement }}</span>
                                <span class="flex items-center gap-2 text-[#b8860b]">💰 ENTRY: {{ number_format($race->entry_fee) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-8 relative z-10 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 border-white/5 pt-6 md:pt-0">
                            <div class="text-right">
                                <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Est. Purse</span>
                                <span class="text-2xl md:text-4xl font-industrial font-black text-[#b8860b] italic drop-shadow-lg">{{ number_format($race->prize_pool) }}💰</span>
                            </div>
                            
                            <button wire:click="enterRace({{ $race->id }})" 
                                    class="bg-white hover:bg-[#b8860b] text-black hover:text-white font-industrial font-black px-10 py-4 rounded-[1.5rem] transition-all shadow-2xl active:scale-95 uppercase italic text-sm tracking-widest">
                                Enter Bird
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

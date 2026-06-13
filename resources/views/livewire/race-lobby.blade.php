<div class="text-slate-200">
    @if (session()->has('race_error'))
        <div class="p-4 bg-red-900/30 border border-red-500/50 rounded-2xl mb-8 animate-pulse">
            <p class="text-sm text-red-400 font-bold uppercase tracking-widest text-center">⚠ {{ session('race_error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Left: Pigeon Selection -->
        <div class="lg:col-span-1 space-y-6">
            <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] mb-4 ml-1 italic">Assign Asset</h3>
            <div class="relative group">
                <select wire:model="selectedPigeonId" 
                        class="w-full bg-slate-900 border-2 border-slate-800 rounded-2xl p-4 text-white font-bold focus:border-yellow-500 transition-all appearance-none cursor-pointer">
                    <option value="">SELECT READY UNIT</option>
                    @foreach($readyPigeons as $p)
                        <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }} - {{ strtoupper($p->type) }}]</option>
                    @endforeach
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-yellow-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter ml-1">Only units with >50% energy are available for deployment.</p>
        </div>

        <!-- Right: Tournament List -->
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] mb-4 ml-1 italic">Deployment Zones</h3>
            <div class="grid grid-cols-1 gap-4">
                @foreach($races as $race)
                    <div class="group bg-slate-900 border-2 border-slate-800 rounded-[2rem] p-6 hover:border-yellow-500/50 transition-all duration-300 shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[10px] font-black bg-yellow-500 text-black px-2 py-0.5 rounded italic uppercase">{{ $race->race_type }}</span>
                                <h4 class="text-xl font-industrial font-black text-white italic tracking-widest uppercase">{{ $race->title }}</h4>
                            </div>
                            <div class="flex gap-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                <span>Dist: {{ $race->distance_km }}KM</span>
                                <span>|</span>
                                <span>Min Lv: {{ $race->level_requirement }}</span>
                                <span>|</span>
                                <span>Fee: {{ number_format($race->entry_fee) }}💰</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <span class="block text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Potential Payout</span>
                                <span class="text-2xl font-industrial font-black text-yellow-500">{{ number_format($race->prize_pool) }}💰</span>
                            </div>
                            
                            <button wire:click="enterRace({{ $race->id }})" 
                                    class="bg-white hover:bg-yellow-500 text-black font-industrial font-black px-8 py-3 rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic text-xs tracking-widest">
                                Deploy
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

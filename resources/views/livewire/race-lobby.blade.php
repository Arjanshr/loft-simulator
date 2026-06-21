<div class="space-y-12 font-sans text-slate-300">
    @if (session()->has('race_error'))
        <div class="p-6 bg-red-950/20 border border-red-500/30 rounded-2xl mb-10 animate-pulse text-center galvanized-border">
            <p class="text-sm text-red-500 font-black uppercase tracking-widest italic">Warning: {{ session('race_error') }}</p>
        </div>
    @endif

    @if($activeRaceType)
        <div class="flex flex-col gap-4 rounded-[2rem] border border-aviary-blue/20 bg-aviary-blue/10 p-5 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-blue mb-2">Redo Filter</p>
                <h3 class="text-xl font-black italic uppercase text-white leading-none">Showing {{ strtoupper($activeRaceType) }} races</h3>
            </div>
            <a href="{{ route('tournaments') }}" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/10 px-5 py-3 text-[10px] font-black uppercase tracking-[0.3em] text-white/80 transition-all hover:bg-white/20">
                Show all races
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Left: Bird Selection - The Tactical Assignment -->
        <div class="lg:col-span-1 space-y-8 parchment-panel p-8 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl galvanized-border">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-1.5 h-6 bg-aviary-brass rounded-full shadow-[0_0_10px_#b8860b]"></div>
                <h3 class="text-[11px] font-black text-white uppercase tracking-[0.3em] italic">Unit Assignment</h3>
            </div>

            <div class="relative group">
                <div class="max-h-48 overflow-y-auto bg-aviary-oak/60 border-2 border-aviary-brass/10 rounded-2xl p-4 text-white font-mono text-sm shadow-inner space-y-2">
                    @forelse($readyPigeons as $p)
                        <label class="flex items-center gap-3 cursor-pointer hover:bg-white/5 p-2 rounded-lg transition">
                            <input type="checkbox" wire:model="selectedPigeonIds" value="{{ $p->id }}" class="form-checkbox bg-black/50 border-aviary-brass/50 text-aviary-blue rounded focus:ring-aviary-blue">
                            <span>{{ $p->name }} <span class="text-aviary-feather/50">[LV.{{ $p->level }} - {{ strtoupper($p->type) }}]</span></span>
                        </label>
                    @empty
                        <div class="text-aviary-feather/50 italic p-2 text-center">No ready specimens (Condition >= 10%)</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-[11px] font-black text-white uppercase tracking-[0.3em] italic mb-3">Reward Multiplier</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach([1, 2, 5, 10] as $mul)
                        <button wire:click="$set('rewardMultiplier', {{ $mul }})" type="button" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all {{ $rewardMultiplier === $mul ? 'bg-aviary-blue border-aviary-blue text-white shadow-[0_0_15px_rgba(59,130,246,0.3)]' : 'bg-black/30 border-white/10 text-white/60 hover:border-white/30' }}">
                            {{ $mul }}X
                        </button>
                    @endforeach
                </div>
                <p class="text-[9px] text-aviary-feather/40 uppercase tracking-widest italic mt-3">Multiplies entry fee and potential rewards per bird.</p>
            </div>

            <div class="bg-black/30 p-5 rounded-2xl border border-aviary-brass/5">
                <p class="text-[10px] text-aviary-feather/40 font-bold uppercase tracking-widest italic leading-relaxed">Flight Protocol: Specimens must have enough condition for the selected multiplier (10 condition per 1x multiplier). Only specimens with >= 10% are listed.</p>
            </div>
        </div>

        <!-- Right: Tournament List - The Racing Registry -->
        <div class="lg:col-span-2 space-y-8">
            <div class="flex items-center gap-4 mb-6 px-4">
                <div class="w-1.5 h-6 bg-aviary-blue rounded-full shadow-[0_0_10px_#3b82f6]"></div>
                <h3 class="text-[11px] font-black text-white uppercase tracking-[0.3em] italic">Tournament Registry</h3>
            </div>

            <div class="grid grid-cols-1 gap-8">
                @foreach($races as $race)
                    <div class="group parchment-panel border-2 border-aviary-brass/10 rounded-[3rem] p-6 md:p-10 hover:border-aviary-blue/30 transition-all duration-500 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-10 relative overflow-hidden galvanized-border">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-aviary-brass/10 group-hover:bg-aviary-blue transition-all duration-500"></div>

                        <div class="flex-1 relative z-10">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
                                <span class="text-[9px] font-black bg-aviary-blue/10 text-aviary-blue px-4 py-1.5 rounded-full italic uppercase border border-aviary-blue/20 tracking-widest font-mono">{{ $race->race_type }}</span>
                                <h4 class="text-3xl md:text-4xl font-industrial font-black text-white italic tracking-tighter uppercase leading-none">{{ $race->title }}</h4>
                            </div>
                            <div class="flex flex-wrap gap-8 text-[10px] font-mono font-bold text-aviary-feather/40 uppercase tracking-widest italic">
                                <span class="flex items-center gap-3"><span class="text-aviary-brass">🏁</span> {{ $race->distance_km }}KM COURSE</span>
                                <span class="flex items-center gap-3"><span class="text-aviary-brass">🎖️</span> MIN LV.{{ $race->level_requirement }}</span>
                                <span class="flex items-center gap-3 text-aviary-brass drop-shadow-sm"><span class="text-white">{{ $race->race_type === 'exhibition' ? '💊' : '💰' }}</span> ENTRY: {{ number_format($race->entry_fee) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-10 relative z-10 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 border-aviary-brass/10 pt-8 md:pt-0">
                            <div class="text-right">
                                <span class="block text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mb-2 italic">Official Purse</span>
                                <span class="text-3xl md:text-5xl font-industrial font-black text-aviary-brass italic trophy-gold">{{ number_format($race->prize_pool) }}{{ $race->race_type === 'exhibition' ? '💊' : '💰' }}</span>
                            </div>

                            <button wire:click="enterRace({{ $race->id }})"
                                    class="bg-white hover:bg-aviary-blue text-black hover:text-white font-industrial font-black px-12 py-5 rounded-[2rem] transition-all shadow-2xl active:scale-95 uppercase italic text-sm tracking-widest border-2 border-black/5 group">
                                <span class="group-hover:scale-105 transition-transform block">Authorize Flight</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden font-sans text-slate-300 galvanized-border">
    <!-- Background Decorative Element -->
    <div class="absolute top-0 right-0 p-4 md:p-10 opacity-[0.03] text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Prestige</div>

    <div class="relative z-10">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 md:gap-12 mb-12 md:mb-16 border-b border-aviary-brass/10 pb-10">
            <div class="flex items-center gap-6 w-full lg:w-auto">
                <div class="w-12 h-1.5 bg-aviary-brass rounded-full shadow-[0_0_15px_#b8860b]"></div>
                <div>
                    <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">Hall of Fame</h2>
                    <p class="text-aviary-feather/40 text-[10px] md:text-xs font-black uppercase tracking-[0.4em] italic">Official Registry of Champion Bloodlines</p>
                </div>
            </div>
            
            <div class="w-full lg:w-80">
                <label class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest mb-2 block italic">Registry Strain Filter</label>
                <select wire:model.live="filter" class="w-full bg-aviary-oak/60 border-2 border-aviary-brass/10 rounded-2xl px-6 py-4 text-xs md:text-sm font-black text-aviary-brass uppercase tracking-widest focus:border-aviary-blue transition-all cursor-pointer italic appearance-none">
                    <option value="overall">OVERALL NETWORK</option>
                    <option value="fancy">FANCY STRAINS</option>
                    <option value="racer">RACING STRAINS</option>
                    <option value="highflyer">HIGH FLYER STRAINS</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-20">
            <!-- Top Specimens: Champion Stock -->
            <div class="space-y-10">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span>
                    <h3 class="text-[11px] font-black text-aviary-blue uppercase tracking-[0.4em] italic border-b border-aviary-blue/20 pb-3 flex-1">Champion Specimens</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($topPigeons as $index => $pigeon)
                        <div class="group relative flex justify-between items-center p-6 rounded-[2rem] transition-all duration-500 overflow-hidden shadow-xl border-2 {{ $index === 0 ? 'bg-aviary-brass/5 border-aviary-brass/40 shadow-aviary-brass/10' : 'bg-aviary-oak/40 border-aviary-brass/5 hover:border-aviary-blue/30' }} galvanized-border">
                            <div class="flex items-center gap-6 truncate mr-4 relative z-10">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-industrial font-black text-2xl italic {{ $index === 0 ? 'bg-aviary-brass text-white shadow-lg' : 'bg-black/20 text-aviary-feather/30' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="truncate">
                                    <p class="font-industrial font-black text-white uppercase tracking-widest text-base md:text-lg truncate italic leading-none mb-2">{{ $pigeon->name }}</p>
                                    <p class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest truncate italic">{{ $pigeon->loft->name }}</p>
                                </div>
                            </div>
                            <div class="text-right relative z-10">
                                <span class="text-[9px] font-black text-aviary-feather/40 uppercase block mb-1 tracking-widest italic">Points</span>
                                <span class="font-mono font-bold text-lg md:text-2xl text-aviary-brass italic">{{ number_format($pigeon->total_score, 1) }}</span>
                            </div>
                            @if($index === 0)
                                <div class="absolute inset-0 bg-gradient-to-r from-aviary-brass/5 to-transparent"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Master Breeders: Top Lofts -->
            <div class="space-y-10">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-aviary-brass rounded-full shadow-[0_0_8px_#b8860b]"></span>
                    <h3 class="text-[11px] font-black text-aviary-brass uppercase tracking-[0.4em] italic border-b border-aviary-brass/20 pb-3 flex-1">Master Breeders</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($topLofts as $index => $loft)
                        <div class="group relative flex justify-between items-center p-6 rounded-[2rem] transition-all duration-500 overflow-hidden shadow-xl border-2 {{ $index === 0 ? 'bg-aviary-brass/5 border-aviary-brass/40 shadow-aviary-brass/10' : 'bg-aviary-oak/40 border-aviary-brass/5 hover:border-aviary-blue/30' }} galvanized-border">
                            <div class="flex items-center gap-6 truncate mr-4 relative z-10">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-industrial font-black text-2xl italic {{ $index === 0 ? 'bg-aviary-brass text-white shadow-lg' : 'bg-black/20 text-aviary-feather/30' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="truncate">
                                    @php
                                        $loftModel = \App\Models\Loft::where('name', $loft['name'])->first();
                                    @endphp
                                    <a href="{{ route('loft.view', ['loftId' => $loftModel->id]) }}" 
                                       class="font-industrial font-black text-white uppercase tracking-widest text-base md:text-lg hover:text-aviary-blue transition-colors italic leading-none mb-2 block">
                                        {{ $loft['name'] }}
                                    </a>
                                    <p class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mt-1 italic">Registry Grade {{ $loft['level'] }}</p>
                                </div>
                            </div>
                            <div class="text-right relative z-10">
                                <span class="text-[9px] font-black text-aviary-feather/40 uppercase block mb-1 tracking-widest italic">Prestige</span>
                                <span class="font-mono font-bold text-lg md:text-2xl text-aviary-brass italic">{{ number_format($loft['score'], 1) }}</span>
                            </div>
                            @if($index === 0)
                                <div class="absolute inset-0 bg-gradient-to-r from-aviary-brass/5 to-transparent"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

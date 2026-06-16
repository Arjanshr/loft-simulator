<div class="bg-[#050a0a] p-6 md:p-10 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden font-sans text-slate-300">
    <div class="absolute top-0 right-0 p-4 md:p-10 opacity-5 text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">Prestige</div>

    <div class="relative z-10">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 md:gap-12 mb-12 md:mb-16">
            <div class="flex items-center gap-6 w-full lg:w-auto">
                <div class="w-12 h-1 bg-[#b8860b] rounded-full shadow-[0_0_15px_rgba(184,134,11,0.3)]"></div>
                <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight">Hall of Fame</h2>
            </div>
            
            <select wire:model.live="filter" class="w-full lg:w-auto bg-[#0a1414] border-2 border-[#b8860b]/20 rounded-2xl px-8 py-4 text-xs md:text-sm font-black text-[#b8860b] uppercase tracking-widest focus:border-[#b8860b] transition-all cursor-pointer italic">
                <option value="overall">OVERALL NETWORK</option>
                <option value="fancy">FANCY STRAINS</option>
                <option value="racer">RACING STRAINS</option>
                <option value="highflyer">HIGH FLYER STRAINS</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16">
            <!-- Top Pigeons -->
            <div class="space-y-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-6 ml-2 italic border-b border-white/5 pb-3">Champion Stock</h3>
                <div class="space-y-3">
                    @foreach($topPigeons as $index => $pigeon)
                        <div class="group flex justify-between items-center p-5 rounded-2xl transition-all duration-300 {{ $index === 0 ? 'bg-[#b8860b]/10 border-2 border-[#b8860b]/40 shadow-lg' : 'bg-black/40 border border-white/5 hover:border-[#b8860b]/20' }}">
                            <div class="flex items-center gap-5 truncate mr-4">
                                <span class="font-industrial font-black text-xl md:text-2xl {{ $index === 0 ? 'text-[#b8860b]' : 'text-slate-700' }} w-10 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    <p class="font-industrial font-black text-white uppercase tracking-widest text-sm md:text-base truncate italic">{{ $pigeon->name }}</p>
                                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest truncate mt-1 italic">{{ $pigeon->loft->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[8px] font-black text-slate-600 uppercase block tracking-tighter">Points</span>
                                <span class="font-industrial font-black text-base md:text-xl text-[#b8860b] italic">{{ number_format($pigeon->total_score, 1) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Lofts -->
            <div class="space-y-8">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-6 ml-2 italic border-b border-white/5 pb-3">Master Breeders</h3>
                <div class="space-y-3">
                    @foreach($topLofts as $index => $loft)
                        <div class="group flex justify-between items-center p-5 rounded-2xl transition-all duration-300 {{ $index === 0 ? 'bg-[#b8860b]/10 border-2 border-[#b8860b]/40 shadow-lg' : 'bg-black/40 border border-white/5 hover:border-[#b8860b]/20' }}">
                            <div class="flex items-center gap-5 truncate mr-4">
                                <span class="font-industrial font-black text-xl md:text-2xl {{ $index === 0 ? 'text-[#b8860b]' : 'text-slate-700' }} w-10 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    @php
                                        $loftModel = \App\Models\Loft::where('name', $loft['name'])->first();
                                    @endphp
                                    <a href="{{ route('loft.view', ['loftId' => $loftModel->id]) }}" 
                                       class="font-industrial font-black text-white uppercase tracking-widest text-sm md:text-base hover:text-[#b8860b] transition-colors italic">
                                        {{ $loft['name'] }}
                                    </a>
                                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1 italic">Loft Level {{ $loft['level'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[8px] font-black text-slate-600 uppercase block tracking-tighter">Prestige</span>
                                <span class="font-industrial font-black text-base md:text-xl text-[#b8860b] italic">{{ number_format($loft['score'], 1) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

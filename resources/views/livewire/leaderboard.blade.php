<div class="bg-slate-950 p-6 md:p-10 rounded-[2rem] md:rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
    <div class="absolute top-0 right-0 p-4 md:p-8 opacity-5 text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Global</div>

    <div class="relative z-10">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 md:gap-8 mb-8 md:mb-12">
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <div class="w-8 md:w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight">Operational Rankings</h2>
            </div>
            
            <select wire:model.live="filter" class="w-full lg:w-auto bg-slate-900 border-2 border-slate-800 rounded-2xl px-6 py-3 text-xs md:text-sm font-black text-yellow-500 uppercase tracking-widest focus:border-yellow-500 transition-all cursor-pointer">
                <option value="overall">OVERALL NETWORK</option>
                <option value="fancy">FANCY UNITS</option>
                <option value="racer">RACER UNITS</option>
                <option value="highflyer">HIGH FLYER UNITS</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <!-- Top Pigeons -->
            <div class="space-y-6">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] md:tracking-[0.3em] mb-4 ml-2 italic">Elite Assets</h3>
                <div class="space-y-2">
                    @foreach($topPigeons as $index => $pigeon)
                        <div class="group flex justify-between items-center p-4 rounded-2xl transition-all {{ $index === 0 ? 'bg-yellow-500/10 border-2 border-yellow-500/30' : 'bg-slate-900/50 border border-slate-800' }}">
                            <div class="flex items-center gap-3 md:gap-4 truncate mr-4">
                                <span class="font-industrial font-black text-lg md:text-xl {{ $index === 0 ? 'text-yellow-500' : 'text-slate-600' }} w-8 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    <p class="font-industrial font-black text-white uppercase tracking-wider text-xs md:text-sm truncate">{{ $pigeon->name }}</p>
                                    <p class="text-[8px] md:text-[9px] font-black text-slate-500 uppercase tracking-widest truncate">{{ $pigeon->loft->name }}</p>
                                </div>
                            </div>
                            <span class="font-industrial font-black text-base md:text-lg text-yellow-500">{{ number_format($pigeon->total_score, 1) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Lofts -->
            <div class="space-y-6">
                <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] md:tracking-[0.3em] mb-4 ml-2 italic">Master Operators</h3>
                <div class="space-y-2">
                    @foreach($topLofts as $index => $loft)
                        <div class="group flex justify-between items-center p-4 rounded-2xl transition-all {{ $index === 0 ? 'bg-yellow-500/10 border-2 border-yellow-500/30' : 'bg-slate-900/50 border border-slate-800' }}">
                            <div class="flex items-center gap-3 md:gap-4 truncate mr-4">
                                <span class="font-industrial font-black text-lg md:text-xl {{ $index === 0 ? 'text-yellow-500' : 'text-slate-600' }} w-8 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    <a href="{{ route('loft.view', ['loftId' => \App\Models\Loft::where('name', $loft['name'])->first()->id]) }}" 
                                       class="font-industrial font-black text-white uppercase tracking-wider text-xs md:text-sm hover:text-yellow-500 transition-colors">
                                        {{ $loft['name'] }}
                                    </a>
                                    <p class="text-[8px] md:text-[9px] font-black text-slate-500 uppercase tracking-widest">Loft Level {{ $loft['level'] }}</p>
                                </div>
                            </div>
                            <span class="font-industrial font-black text-base md:text-lg text-yellow-500">{{ number_format($loft['score'], 1) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
    <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Global</div>

    <div class="relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12">
            <div class="flex items-center gap-4">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Operational Rankings</h2>
            </div>
            
            <select wire:model.live="filter" class="bg-slate-900 border-2 border-slate-800 rounded-2xl px-6 py-3 text-sm font-black text-yellow-500 uppercase tracking-widest focus:border-yellow-500 transition-all cursor-pointer">
                <option value="overall">OVERALL NETWORK</option>
                <option value="fancy">FANCY UNITS</option>
                <option value="racer">RACER UNITS</option>
                <option value="highflyer">HIGH FLYER UNITS</option>
            </select>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Top Pigeons -->
            <div class="space-y-6">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] mb-4 ml-2 italic">Elite Assets</h3>
                <div class="space-y-2">
                    @foreach($topPigeons as $index => $pigeon)
                        <div class="group flex justify-between items-center p-4 rounded-2xl transition-all {{ $index === 0 ? 'bg-yellow-500/10 border-2 border-yellow-500/30' : 'bg-slate-900/50 border border-slate-800' }}">
                            <div class="flex items-center gap-4 truncate mr-4">
                                <span class="font-industrial font-black text-xl {{ $index === 0 ? 'text-yellow-500' : 'text-slate-600' }} w-8 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    <p class="font-industrial font-black text-white uppercase tracking-wider text-sm truncate">{{ $pigeon->name }}</p>
                                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest truncate">{{ $pigeon->loft->name }}</p>
                                </div>
                            </div>
                            <span class="font-industrial font-black text-lg text-yellow-500">{{ number_format($pigeon->total_score, 1) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Lofts -->
            <div class="space-y-6">
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] mb-4 ml-2 italic">Master Operators</h3>
                <div class="space-y-2">
                    @foreach($topLofts as $index => $loft)
                        <div class="group flex justify-between items-center p-4 rounded-2xl transition-all {{ $index === 0 ? 'bg-yellow-500/10 border-2 border-yellow-500/30' : 'bg-slate-900/50 border border-slate-800' }}">
                            <div class="flex items-center gap-4 truncate mr-4">
                                <span class="font-industrial font-black text-xl {{ $index === 0 ? 'text-yellow-500' : 'text-slate-600' }} w-8 italic">#{{ $index + 1 }}</span>
                                <div class="truncate">
                                    <a href="{{ route('loft.view', ['loftId' => \App\Models\Loft::where('name', $loft['name'])->first()->id]) }}" 
                                       class="font-industrial font-black text-white uppercase tracking-wider text-sm hover:text-yellow-500 transition-colors">
                                        {{ $loft['name'] }}
                                    </a>
                                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Loft Level {{ $loft['level'] }}</p>
                                </div>
                            </div>
                            <span class="font-industrial font-black text-lg text-yellow-500">{{ number_format($loft['score'], 1) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

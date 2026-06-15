<div class="space-y-12">
    <!-- Local Strays -->
    <div class="space-y-8">
        <div class="bg-slate-950 p-8 rounded-[2.5rem] border border-slate-800">
            <h2 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest mb-2">Observation Deck</h2>
            <p class="text-xs font-black text-slate-500 uppercase tracking-[0.3em]">Monitoring the loft roof for incoming stray biological signatures</p>
        </div>

        @if($strays->isEmpty())
            <div class="py-20 text-center border-2 border-dashed border-slate-800 rounded-[3rem]">
                <p class="text-sm font-industrial font-black text-slate-600 uppercase tracking-[0.5em]">No stray signatures detected on perimeter.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($strays as $stray)
                    <div class="bg-blue-950/20 border-2 border-blue-500/30 rounded-3xl p-6 flex flex-col justify-between group hover:border-blue-500/60 transition-all">
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-blue-500 text-white font-industrial font-black text-[10px] px-2 py-0.5 rounded italic">LV.{{ $stray->level }}</span>
                                <h4 class="font-industrial font-black text-white uppercase tracking-wider text-sm">{{ $stray->name }}</h4>
                            </div>
                            <div class="flex gap-2">
                                <span class="text-[8px] font-black text-blue-300 uppercase tracking-widest border border-blue-500/20 px-2 py-0.5 rounded-full">{{ $stray->rarity }}</span>
                                <span class="text-[8px] font-black text-blue-300 uppercase tracking-widest border border-blue-500/20 px-2 py-0.5 rounded-full">{{ $stray->type }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-blue-500/20 pt-4">
                            @php
                                $userLoft = Auth::user()->loft;
                                $chance = 15 + ($userLoft->level - $stray->level) * 2;
                                $chance = max(5, min(95, $chance));
                            @endphp
                            <div>
                                <span class="block text-[8px] font-black text-blue-400 uppercase tracking-widest mb-1">Capture Chance</span>
                                <span class="text-lg font-industrial font-black text-white">{{ $chance }}%</span>
                            </div>
                            <button wire:click="attemptCatch({{ $stray->id }})" 
                                    class="bg-blue-500 hover:bg-blue-400 text-white font-industrial font-black px-6 py-2 rounded-xl transition shadow-lg shadow-blue-500/20 text-[10px] uppercase tracking-widest italic active:scale-95">
                                Capture
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Global Lost Feed -->
    <div class="space-y-6">
        <h3 class="text-lg font-industrial font-black text-white uppercase italic tracking-widest">Global Lost Feed</h3>
        <div class="bg-slate-900/50 rounded-3xl border border-slate-800 p-6">
            <div class="space-y-4">
                @foreach($globalLostBirds as $bird)
                    <div class="flex items-center justify-between text-xs font-black text-slate-400 border-b border-white/5 pb-4">
                        <span class="text-yellow-500">{{ $bird->lost_at->format('m/d H:i') }}</span>
                        <span class="text-white uppercase">{{ $bird->name }} (Lv.{{ $bird->level }} {{ $bird->type }})</span>
                        <span>LOST FROM: <span class="text-slate-200">{{ $bird->loft->name }}</span></span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

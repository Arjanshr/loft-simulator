<div class="space-y-12">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-yellow-500 text-black px-6 py-3 rounded-xl shadow-2xl font-black font-industrial border-2 border-black">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="err-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial border-2 border-white">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-slate-950 p-6 md:p-12 rounded-[2.5rem] md:rounded-[4rem] border-b-8 border-r-8 border-slate-900 shadow-[20px_20px_0px_0px_rgba(15,23,42,1)] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 p-12 opacity-[0.03] text-9xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter">Market</div>
        <div class="absolute bottom-0 left-0 p-12 opacity-[0.02] text-9xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter">Terminal</div>

        <div class="relative z-10">
            <!-- Asset Management Section -->
            <div class="mb-20">
                <livewire:my-listings />
            </div>

            <!-- Global Listings Header -->
            <div class="flex flex-col md:flex-row items-center gap-6 mb-12 px-4">
                <div class="flex items-center gap-4">
                    <div class="w-3 h-12 bg-yellow-500 rounded-full shadow-[0_0_15px_rgba(234,179,8,0.4)]"></div>
                    <div>
                        <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-tighter leading-none">Global Terminal</h2>
                        <p class="text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-[0.3em] mt-2">Pigeon Acquisition & Unit Exchange Protocol</p>
                    </div>
                </div>
                <div class="hidden md:block flex-1 h-[1px] bg-gradient-to-r from-slate-800 to-transparent"></div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-8 md:gap-10">
                @foreach($listings as $listing)
                    <div class="group relative bg-slate-900/40 rounded-[2.5rem] border-2 border-slate-800/60 p-1 hover:border-yellow-500/40 transition-all duration-500 shadow-2xl">
                        <div class="bg-slate-950 rounded-[2.3rem] p-6 md:p-8 flex flex-col h-full border border-slate-800/50">
                            <!-- Header: Name & Rarity -->
                            <div class="flex justify-between items-start mb-8">
                                <div class="space-y-2 max-w-[65%]">
                                    <h3 class="text-xl md:text-2xl font-industrial font-black text-white italic tracking-tight uppercase truncate leading-none">{{ $listing->pigeon->name }}</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="text-[9px] font-black bg-yellow-500 text-black px-2 py-0.5 rounded italic">LV.{{ $listing->pigeon->level }}</span>
                                        <span class="text-[9px] font-black bg-slate-800 text-slate-300 px-2 py-0.5 rounded italic uppercase tracking-tighter">{{ $listing->pigeon->rarity }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-black text-slate-600 uppercase block mb-1 tracking-widest">Price Point</span>
                                    <span class="text-2xl md:text-3xl font-industrial font-black text-yellow-500 drop-shadow-[0_0_8px_rgba(234,179,8,0.3)]">{{ number_format($listing->price) }}💰</span>
                                </div>
                            </div>

                            <!-- Stat Panels -->
                            <div class="grid grid-cols-1 gap-4 mb-8">
                                <div class="bg-slate-900/50 rounded-2xl p-4 border border-slate-800/50 group-hover:border-slate-700/50 transition-colors">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Performance Matrix</span>
                                        <span class="text-[10px] font-black text-white italic tracking-tighter">TOTAL: {{ $listing->pigeon->speed + $listing->pigeon->endurance + $listing->pigeon->navigation + $listing->pigeon->temperament }}</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-500 uppercase">SPD</span> <span class="text-xs font-black text-white">{{ $listing->pigeon->speed }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-500 uppercase">POW</span> <span class="text-xs font-black text-white">{{ $listing->pigeon->endurance }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-500 uppercase">DIR</span> <span class="text-xs font-black text-white">{{ $listing->pigeon->navigation }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-500 uppercase">MND</span> <span class="text-xs font-black text-white">{{ $listing->pigeon->temperament }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-yellow-500 uppercase">INT</span> <span class="text-xs font-black text-white">{{ $listing->pigeon->intelligence }}</span></div>
                                    </div>
                                </div>

                                <div class="bg-slate-900/50 rounded-2xl p-4 border border-slate-800/50 group-hover:border-slate-700/50 transition-colors">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Aesthetic DNA</span>
                                        <div class="flex items-center gap-1">
                                            <span class="text-[10px] font-black text-yellow-500">{{ $listing->pigeon->stat_grades['beauty'] }}</span>
                                            <span class="text-sm font-industrial font-black text-white">{{ number_format($listing->pigeon->beauty, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                                        @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'PRT'] as $stat => $abbr)
                                            <div class="flex flex-col">
                                                <span class="text-[6px] font-bold text-slate-600 uppercase">{{ $abbr }}</span>
                                                <span class="text-[9px] font-black text-slate-300">{{ number_format($listing->pigeon->$stat, 1) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-8 text-[9px] font-black uppercase tracking-widest text-slate-500 bg-black/20 p-3 rounded-xl border border-slate-800/30">
                                <div class="flex justify-between"><span>Gender:</span> <span class="{{ $listing->pigeon->gender == 'male' ? 'text-blue-400' : 'text-pink-400' }}">{{ $listing->pigeon->gender }}</span></div>
                                <div class="flex justify-between"><span>Type:</span> <span class="text-slate-300">{{ $listing->pigeon->type }}</span></div>
                            </div>
                            
                            <!-- Timer & Action -->
                            <div class="mt-auto space-y-4">
                                @php
                                    $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                                    $isExpired = $remainingSecs <= 0;
                                @endphp
                                <div class="flex justify-between items-center px-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full {{ $isExpired ? 'bg-red-500 animate-pulse' : 'bg-green-500 animate-pulse' }}"></div>
                                        <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $isExpired ? 'text-red-500' : 'text-slate-400' }}">
                                            {{ $isExpired ? 'Listing Expired' : 'Terminal Online' }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] font-black text-white uppercase italic">
                                        {{ $isExpired ? '00:00:00' : gmdate("H:i:s", $remainingSecs) }}
                                    </span>
                                </div>

                                <button wire:click="buy({{ $listing->id }})" 
                                        @if($isExpired) disabled @endif
                                        class="w-full py-5 {{ $isExpired ? 'bg-slate-800 text-slate-500 cursor-not-allowed' : 'bg-white hover:bg-yellow-500 active:scale-[0.98]' }} text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-[0.2em] relative overflow-hidden group/btn">
                                    <span class="relative z-10">Authorize Acquisition</span>
                                    <div class="absolute inset-0 bg-yellow-400 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($listings->isEmpty())
                <div class="py-32 text-center border-2 border-dashed border-slate-800 rounded-[3rem]">
                    <div class="text-6xl mb-6 opacity-20">📡</div>
                    <p class="text-sm font-industrial font-black text-slate-600 uppercase tracking-[0.5em]">No active signals found in the global exchange</p>
                </div>
            @endif
        </div>
    </div>
</div>

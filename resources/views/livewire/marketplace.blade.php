<div class="space-y-12 font-sans text-slate-300">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-[#b8860b] text-white px-6 py-3 rounded-xl shadow-2xl font-black font-industrial border-2 border-white/20 italic animate-bounce">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="err-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-red-800 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial border-2 border-white/20 italic">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-[#050a0a] p-6 md:p-12 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/10 shadow-2xl relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 p-12 opacity-5 text-9xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter text-[#b8860b]">Exchange</div>
        <div class="absolute bottom-0 left-0 p-12 opacity-[0.02] text-9xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter text-[#b8860b]">Ledger</div>

        <div class="relative z-10">
            <!-- Asset Management Section -->
            <div class="mb-20">
                <livewire:my-listings />
            </div>

            <!-- Global Listings Header -->
            <div class="flex flex-col md:flex-row items-center gap-6 mb-12 px-4">
                <div class="flex items-center gap-6">
                    <div class="w-3 h-16 bg-[#b8860b] rounded-full shadow-[0_0_15px_rgba(184,134,11,0.4)]"></div>
                    <div>
                        <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-tighter leading-none mb-2">Pigeon Exchange</h2>
                        <p class="text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-[0.4em] italic">Official Bird Auction & Public Trading Ledger</p>
                    </div>
                </div>
                <div class="hidden md:block flex-1 h-[1px] bg-gradient-to-r from-[#b8860b]/20 to-transparent"></div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-8 md:gap-12">
                @foreach($listings as $listing)
                    <div class="group relative bg-[#0a1414] rounded-[2.5rem] border-2 border-[#b8860b]/10 p-1 hover:border-[#b8860b]/40 transition-all duration-500 shadow-2xl overflow-hidden">
                        <div class="bg-[#050a0a] rounded-[2.3rem] p-6 md:p-8 flex flex-col h-full border border-white/5 relative z-10">
                            <!-- Header: Name & Rarity -->
                            <div class="flex justify-between items-start mb-10">
                                <div class="space-y-3 max-w-[65%]">
                                    <h3 class="text-xl md:text-3xl font-industrial font-black text-white italic tracking-tight uppercase truncate leading-none drop-shadow-lg">{{ $listing->pigeon->name }}</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="text-[9px] font-black bg-[#b8860b] text-white px-3 py-1 rounded-lg italic shadow-lg">LV.{{ $listing->pigeon->level }}</span>
                                        <span class="text-[9px] font-black bg-black/40 text-slate-400 px-3 py-1 rounded-lg italic uppercase tracking-widest border border-white/5">{{ $listing->pigeon->rarity }} Heritage</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-black text-slate-500 uppercase block mb-1 tracking-widest italic">Asking Price</span>
                                    <span class="text-2xl md:text-4xl font-industrial font-black text-[#b8860b] drop-shadow-[0_0_8px_rgba(184,134,11,0.3)] italic">{{ number_format($listing->price) }}💰</span>
                                </div>
                            </div>

                            <!-- Stat Panels -->
                            <div class="grid grid-cols-1 gap-6 mb-10">
                                <div class="bg-black/30 rounded-2xl p-5 border border-white/5 group-hover:border-[#b8860b]/20 transition-colors">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Performance Stats</span>
                                        <span class="text-[10px] font-black text-white italic tracking-widest">RANK: {{ $listing->pigeon->level }}</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-y-6 gap-x-4">
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-600 uppercase tracking-widest">Speed</span> <span class="text-sm font-black text-white font-industrial italic">{{ $listing->pigeon->speed }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-600 uppercase tracking-widest">Endurance</span> <span class="text-sm font-black text-white font-industrial italic">{{ $listing->pigeon->endurance }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-600 uppercase tracking-widest">Navigation</span> <span class="text-sm font-black text-white font-industrial italic">{{ $listing->pigeon->navigation }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-slate-600 uppercase tracking-widest">Temperament</span> <span class="text-sm font-black text-white font-industrial italic">{{ $listing->pigeon->temperament }}</span></div>
                                        <div class="flex flex-col"><span class="text-[7px] font-bold text-[#b8860b] uppercase tracking-widest">Intelligence</span> <span class="text-sm font-black text-white font-industrial italic">{{ $listing->pigeon->intelligence }}</span></div>
                                    </div>
                                </div>

                                <div class="bg-black/30 rounded-2xl p-5 border border-white/5 group-hover:border-[#b8860b]/20 transition-colors">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Appearance Standard</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black text-[#b8860b] font-industrial italic">{{ $listing->pigeon->stat_grades['beauty'] }}</span>
                                            <span class="text-xs font-black text-slate-400">/ 100</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-3">
                                        @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'BLO'] as $stat => $abbr)
                                            <div class="flex flex-col text-center">
                                                <span class="text-[6px] font-bold text-slate-600 uppercase mb-1">{{ $abbr }}</span>
                                                <span class="text-[10px] font-black text-slate-300 font-industrial">{{ number_format($listing->pigeon->$stat, 0) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6 mb-10 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-black/40 p-4 rounded-xl border border-white/5 shadow-inner">
                                <div class="flex justify-between"><span>Gender:</span> <span class="{{ $listing->pigeon->gender == 'male' ? 'text-blue-400' : 'text-pink-400' }} italic">{{ $listing->pigeon->gender == 'male' ? 'COCK' : 'HEN' }}</span></div>
                                <div class="flex justify-between"><span>Strain:</span> <span class="text-slate-300 italic">{{ $listing->pigeon->type }}</span></div>
                            </div>
                            
                            <!-- Timer & Action -->
                            <div class="mt-auto space-y-6">
                                @php
                                    $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                                    $isExpired = $remainingSecs <= 0;
                                @endphp
                                <div class="flex justify-between items-center px-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full {{ $isExpired ? 'bg-red-600' : 'bg-green-600 animate-pulse' }}"></div>
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] {{ $isExpired ? 'text-red-500' : 'text-slate-400' }} italic">
                                            {{ $isExpired ? 'Auction Closed' : 'Bidding Open' }}
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-black text-white uppercase italic font-industrial">
                                        {{ $isExpired ? '00:00:00' : gmdate("H:i:s", $remainingSecs) }}
                                    </span>
                                </div>

                                <button wire:click="buy({{ $listing->id }})" 
                                        @if($isExpired) disabled @endif
                                        class="w-full py-6 {{ $isExpired ? 'bg-slate-900 text-slate-600 cursor-not-allowed' : 'bg-white hover:bg-[#b8860b] hover:text-white active:scale-[0.98]' }} text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-2xl uppercase italic tracking-[0.2em] relative overflow-hidden group/btn">
                                    <span class="relative z-10">Purchase Bird</span>
                                    <div class="absolute inset-0 bg-[#b8860b] translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($listings->isEmpty())
                <div class="py-40 text-center border-2 border-dashed border-[#b8860b]/10 rounded-[4rem] bg-black/20">
                    <div class="text-7xl mb-8 opacity-10">📜</div>
                    <p class="text-base font-industrial font-black text-slate-700 uppercase tracking-[0.5em] italic">No active birds registered in the exchange</p>
                </div>
            @endif
        </div>
    </div>
</div>

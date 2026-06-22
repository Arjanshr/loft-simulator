<div class="text-slate-300 font-sans" x-data="{}" x-on:pigeon-leveled-up.window="alert('Congratulations! ' + $event.detail.name + ' reached a new rank!')" wire:poll.60s>
    <!-- Notifications -->
    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
                 class="bg-aviary-blue text-white px-6 py-3 rounded-xl shadow-2xl font-industrial italic border-2 border-white/20 animate-bounce">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
                 class="bg-red-800 text-white px-6 py-3 rounded-xl shadow-2xl font-industrial border-2 border-white/20 italic">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Search & Filter Console: The Registry Desk -->
    <div class="parchment-panel p-6 rounded-[2.5rem] border-2 border-aviary-brass/10 shadow-2xl mb-10 flex flex-col lg:flex-row gap-8 items-center galvanized-border">
        <div class="flex-1 w-full relative">
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-aviary-brass/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="SEARCH REGISTRY RECORDS..." 
                   class="w-full bg-aviary-oak/60 border-2 border-aviary-brass/10 rounded-2xl py-5 pl-16 pr-6 text-white font-mono text-sm focus:border-aviary-blue focus:ring-0 transition-all placeholder-aviary-feather/20 italic uppercase shadow-inner">
        </div>
        
        <div class="flex flex-wrap gap-4 justify-center">
            @foreach(['typeFilter' => ['all' => 'ALL STRAINS', 'racer' => 'RACER', 'fancy' => 'FANCY', 'highflyer' => 'HIGHFLYER'],
                      'rarityFilter' => ['all' => 'ALL HERITAGES', 'common' => 'COMMON', 'rare' => 'RARE', 'super_rare' => 'SUPER RARE', 'legendary' => 'LEGENDARY', 'mythic' => 'MYTHIC'],
                      'sortBy' => ['level' => 'SORT: RANK', 'energy' => 'SORT: CONDITION', 'speed' => 'SORT: SPEED', 'beauty' => 'SORT: APPEARANCE']] as $wire => $opts)
                <div class="relative group">
                    <select wire:model.live="{{ $wire }}" class="bg-aviary-oak/80 border-2 border-aviary-brass/10 rounded-xl pl-6 pr-10 py-3 text-[10px] font-black text-aviary-brass uppercase tracking-widest focus:border-aviary-blue transition-all cursor-pointer appearance-none shadow-md italic">
                        @foreach($opts as $val => $label) <option value="{{ $val }}">{{ $label }}</option> @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-aviary-brass/40">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Units Grid: The Physical Ledger -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-10">
        @foreach($pigeons as $pigeon)
            <div class="group relative bg-aviary-oak/60 rounded-[3rem] border-2 border-aviary-brass/10 hover:border-aviary-blue/30 transition-all duration-500 overflow-hidden shadow-2xl galvanized-border">
                <!-- ID Card Header -->
                <div class="bg-gradient-to-r from-aviary-timber to-aviary-oak p-6 border-b border-aviary-brass/10 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.03] text-4xl font-industrial font-black italic select-none pointer-events-none text-aviary-brass uppercase">{{ $pigeon->type }}</div>
                    
                    <div class="flex justify-between items-start relative z-10">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-aviary-blue text-white font-industrial font-black text-xs px-2 py-0.5 rounded italic shadow-lg">LV.{{ $pigeon->level }}</span>
                                <input type="text" wire:model.lazy="newName.{{ $pigeon->id }}" 
                                       wire:keydown.enter="updateName({{ $pigeon->id }})"
                                       placeholder="{{ $pigeon->name }}" 
                                       class="bg-transparent border-none p-0 text-2xl font-industrial font-black text-white focus:ring-0 w-full placeholder-white/10 italic uppercase tracking-tight">
                            </div>
                            <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" class="mb-3" />
                            <div class="flex flex-wrap gap-2">
                                <!-- Type Label -->
                                <span class="text-[9px] font-black uppercase tracking-widest bg-white/10 text-white px-3 py-1 rounded-full border border-white/20">
                                    {{ strtoupper($pigeon->type) }}
                                </span>
                                @if($pigeon->income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-green-900/20 text-green-400 border border-green-500/20 px-3 py-1 rounded-full">+{{ $pigeon->income_per_minute }} 💰/MIN</span>
                                @endif
                                @if($pigeon->vitamin_income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-emerald-900/20 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full">+{{ $pigeon->vitamin_income_per_minute }} 💊/MIN</span>
                                @endif
                                @if($pigeon->token_income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-purple-900/20 text-purple-400 border border-purple-500/20 px-3 py-1 rounded-full">+{{ $pigeon->token_income_per_minute }} 🎟️/MIN</span>
                                @endif
                            </div>
                        </div>

                        <!-- Vitality Gauge -->
                        <div class="flex flex-col items-end gap-3 bg-black/20 p-4 rounded-2xl border border-aviary-brass/10 shadow-inner">
                            <div class="relative w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 transform -rotate-90">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" class="text-aviary-oak" />
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent"
                                            stroke-dasharray="125.6"
                                            stroke-dashoffset="{{ 125.6 * (1 - ($pigeon->energy / 100)) }}"
                                            class="{{ $pigeon->energy > 30 ? 'text-aviary-blue' : 'text-red-600' }} transition-all duration-1000 shadow-lg" />
                                </svg>
                                <span class="absolute text-[10px] font-black text-white italic font-industrial">{{ $pigeon->energy }}%</span>
                            </div>
                            @if($pigeon->energy < 100)
                                <button wire:click="rest({{ $pigeon->id }})" class="text-[8px] font-black bg-aviary-brass hover:bg-aviary-blue text-white px-3 py-1.5 rounded-lg transition uppercase italic border border-white/10 shadow-md">
                                    Rest (50💊)
                                </button>
                            @endif
                            @if($pigeon->status === 'idle')
                                <button wire:click="quickSell({{ $pigeon->id }})" wire:confirm="Are you sure you want to quick sell this pigeon for {{ (int)($pigeon->fixed_price / 2) }} coins?" class="text-[8px] font-black bg-red-900/80 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg transition uppercase italic border border-white/10 shadow-md mt-1">
                                    Sell ({{ (int)($pigeon->fixed_price / 2) }} 💰)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-8">
                    <!-- Performance Matrix -->
                    @php
                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                        $required = $pigeon->required_stats;
                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                        $loftLevel = Auth::user()->loft->level;
                    @endphp
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-black/20 p-5 rounded-2xl border border-aviary-brass/10 shadow-inner">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3">
                                <span class="italic">Loyalty: {{ $pigeon->loyalty }}%</span>
                                <span class="text-aviary-brass italic">Bond</span>
                            </div>
                            <div class="w-full h-1.5 bg-aviary-oak rounded-full overflow-hidden">
                                <div class="h-full bg-aviary-brass transition-all duration-700 shadow-[0_0_10px_#b8860b]" style="width: {{ $pigeon->loyalty }}%"></div>
                            </div>
                        </div>
                        <div class="bg-black/20 p-5 rounded-2xl border border-aviary-brass/10 shadow-inner">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3">
                                <span class="italic">Intelligence: {{ $pigeon->intelligence }}</span>
                                <span class="text-aviary-blue italic">Intellect</span>
                            </div>
                            <div class="w-full h-1.5 bg-aviary-oak rounded-full overflow-hidden">
                                <div class="h-full bg-aviary-blue transition-all duration-700 shadow-[0_0_10px_#3b82f6]" style="width: {{ $pigeon->intelligence }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Registry -->
                    <div class="parchment-panel p-6 rounded-[2rem] border border-aviary-brass/10 shadow-inner">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-6">
                            <div class="flex-1 w-full">
                                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3 italic">
                                    <span>Promotion Progress</span>
                                    <span class="font-mono text-white">{{ $totalStats }} / {{ $required }} XP</span>
                                </div>
                                <div class="w-full h-2.5 bg-aviary-oak rounded-full overflow-hidden border border-white/5">
                                    <div class="h-full bg-aviary-brass transition-all duration-700 shadow-[0_0_8px_rgba(184,134,11,0.5)]" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            @if($totalStats >= $required && $pigeon->level < 100)
                                @if($pigeon->level < $loftLevel)
                                    <button wire:click="levelUp({{ $pigeon->id }})" 
                                            class="w-full md:w-auto bg-aviary-blue text-white font-industrial font-black text-xs px-8 py-3 rounded-2xl hover:bg-aviary-brass transition shadow-xl uppercase italic border border-white/20 group">
                                        <span class="group-hover:scale-105 transition-transform block">Authorize Rank Up</span>
                                    </button>
                                @else
                                    <div class="px-5 py-2 bg-red-950/20 border border-red-500/20 rounded-xl">
                                        <span class="text-[9px] font-black text-red-500 uppercase tracking-tighter italic">Loft Cap Reached</span>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Technical Matrix -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 font-mono">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] mb-4 italic">Technical Logs</h4>
                                @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP'] as $stat => $abbr)
                                    <div class="relative">
                                        <div class="flex justify-between items-end mb-1.5">
                                            <span class="text-[10px] font-bold text-aviary-feather/60 uppercase italic">{{ $abbr }}</span>
                                            <span class="text-xs font-bold text-white italic">{{ $pigeon->$stat }} <span class="text-aviary-brass text-[9px] ml-1">[{{ $pigeon->stat_grades[$stat] }}]</span></span>
                                        </div>
                                        <div class="h-1 bg-aviary-oak rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full bg-aviary-brass/80 transition-all duration-1000 shadow-[0_0_5px_rgba(184,134,11,0.3)]" style="width: {{ min(100, ($pigeon->$stat / ($pigeon->level * $pigeon->stat_limit_multiplier ?: 10)) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4 bg-black/20 p-5 rounded-2xl border border-aviary-brass/5 shadow-inner">
                                <h4 class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] mb-4 text-center italic">Appearance Std: <span class="text-white ml-1">{{ $pigeon->stat_grades['beauty'] }}</span></h4>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                                    @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'BLO'] as $stat => $abbr)
                                        <div class="flex justify-between items-center border-b border-white/5 pb-1">
                                            <span class="text-[9px] text-aviary-feather/30 uppercase font-bold italic tracking-tighter">{{ $abbr }}</span>
                                            <span class="text-[10px] text-white font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registry Footer -->
                <div class="px-8 py-4 bg-aviary-timber/60 flex justify-between items-center border-t border-aviary-brass/10 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-aviary-blue/5 to-transparent pointer-events-none"></div>
                    <span class="text-[9px] font-bold text-aviary-feather/30 uppercase tracking-[0.2em] italic relative z-10">Sequence: {{ strtoupper($pigeon->status) }}</span>
                    <span class="text-[9px] font-bold text-aviary-feather/30 uppercase tracking-[0.2em] italic relative z-10">Registered: {{ $pigeon->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination: The Archive Sequence -->
    <div class="mt-12 px-6">
        {{ $pigeons->links() }}
    </div>
</div>

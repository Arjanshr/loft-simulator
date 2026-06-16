<div class="text-slate-200" x-data="{}" x-on:pigeon-leveled-up.window="alert('Congratulations! ' + $event.detail.name + ' reached a new rank!')" wire:poll.60s>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-yellow-500 text-black px-6 py-3 rounded-xl shadow-2xl font-black font-industrial animate-bounce">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search & Filter Console -->
    <div class="bg-slate-950 p-6 rounded-[2rem] border-2 border-slate-800 shadow-2xl mb-8 flex flex-col lg:flex-row gap-6 items-center">
        <div class="flex-1 w-full">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="SEARCH ASSET NAME..." 
                   class="w-full bg-black/40 border-2 border-slate-800 rounded-2xl p-4 text-white font-black focus:border-yellow-500 transition-all placeholder-slate-700 font-industrial text-sm">
        </div>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <select wire:model.live="typeFilter" class="bg-slate-900 border-2 border-slate-800 rounded-xl px-4 py-3 text-xs font-black text-yellow-500 uppercase tracking-widest focus:border-yellow-500 transition-all cursor-pointer">
                <option value="all">ALL TYPES</option>
                <option value="racer">RACER</option>
                <option value="fancy">FANCY</option>
                <option value="highflyer">HIGHFLYER</option>
            </select>

            <select wire:model.live="rarityFilter" class="bg-slate-900 border-2 border-slate-800 rounded-xl px-4 py-3 text-xs font-black text-yellow-500 uppercase tracking-widest focus:border-yellow-500 transition-all cursor-pointer">
                <option value="all">ALL RARITIES</option>
                <option value="common">COMMON</option>
                <option value="rare">RARE</option>
                <option value="legendary">LEGENDARY</option>
            </select>

            <select wire:model.live="sortBy" class="bg-slate-900 border-2 border-slate-800 rounded-xl px-4 py-3 text-xs font-black text-yellow-500 uppercase tracking-widest focus:border-yellow-500 transition-all cursor-pointer">
                <option value="level">SORT BY LEVEL</option>
                <option value="energy">SORT BY VITALITY</option>
                <option value="speed">SORT BY SPEED</option>
                <option value="beauty">SORT BY BEAUTY</option>
            </select>
        </div>
    </div>

    <!-- Units Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
        @foreach($pigeons as $pigeon)
            <div class="group relative bg-slate-950 rounded-[2rem] border-2 border-slate-800 hover:border-yellow-500/50 transition-all duration-500 overflow-hidden shadow-2xl">
                <!-- ID Card Header -->
                <div class="bg-gradient-to-r from-slate-900 to-slate-950 p-6 border-b border-slate-800">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <!-- Name & Rank -->
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-yellow-500 text-black font-industrial font-black text-xs px-2 py-0.5 rounded italic">LV.{{ $pigeon->level }}</span>
                                <input type="text" wire:model.lazy="newName.{{ $pigeon->id }}" 
                                       wire:keydown.enter="updateName({{ $pigeon->id }})"
                                       placeholder="{{ $pigeon->name }}" 
                                       class="bg-transparent border-none p-0 text-2xl font-industrial font-black text-white focus:ring-0 w-full placeholder-white/20">
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-1">
                                <span class="text-[10px] font-black uppercase tracking-widest border border-slate-700 text-slate-500 px-2 py-1 rounded-full">{{ $pigeon->type }}</span>
                                <span class="text-[10px] font-black uppercase tracking-widest border border-yellow-500/30 text-yellow-500 px-2 py-1 rounded-full">{{ $pigeon->rarity }}</span>
                                @if($pigeon->income_per_minute > 0)
                                    <span class="text-[10px] font-black uppercase tracking-widest bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded-full">+{{ $pigeon->income_per_minute }} 💰/MIN</span>
                                @endif
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $pigeon->gender == 'male' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-pink-500/10 text-pink-400 border-pink-500/20' }} px-2 py-1 border rounded-full">
                            ...
                                    {{ $pigeon->gender == 'male' ? '♂ MALE' : '♀ FEMALE' }}
                                </span>
                            </div>
                        </div>

                        <!-- Energy Meter -->
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Vitality</span>
                            <div class="relative w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 transform -rotate-90">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" class="text-slate-800" />
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent"
                                            stroke-dasharray="125.6"
                                            stroke-dashoffset="{{ 125.6 * (1 - ($pigeon->energy / 100)) }}"
                                            class="{{ $pigeon->energy > 30 ? 'text-yellow-500' : 'text-red-500' }} transition-all duration-1000" />
                                </svg>
                                <span class="absolute text-[10px] font-black text-white">{{ $pigeon->energy }}%</span>
                            </div>
                            @if($pigeon->energy < 100)
                                <button wire:click="rest({{ $pigeon->id }})" class="mt-2 text-[8px] font-black bg-slate-800 hover:bg-yellow-500 hover:text-black text-slate-400 px-2 py-0.5 rounded transition">
                                    RESTORE (50💰)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Lifecycle Ribbon -->
                    @php
                        $ageDays = $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0;
                        $status = 'Adult';
                        if (!$pigeon->hatch_at || $pigeon->hatch_at->isFuture()) $status = 'Egg';
                        elseif ($pigeon->hatch_at->addDay()->isFuture()) $status = 'Hatchling';
                        elseif ($pigeon->birth_at->addDays(4)->isFuture()) $status = 'Juvenile';

                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                        $required = $pigeon->level * 30;
                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                    @endphp
                    
                    <div class="flex items-center gap-4 mb-6 bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                        <div class="flex-1">
                            <div class="flex justify-between text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                                <span>Lifecycle: {{ $status }}</span>
                                <span>{{ $totalStats }} / {{ $required }} EXP</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-500 transition-all duration-700 shadow-[0_0_10px_rgba(250,204,21,0.5)]" style="width: {{ $progress }}%"></div>
                            </div>
                            @if($pigeon->status === 'egg')
                                <div class="mt-2 flex items-center gap-2 bg-yellow-500/10 p-2 rounded-lg border border-yellow-500/20">
                                    <svg class="w-3 h-3 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-[7px] md:text-[8px] font-black text-yellow-500 uppercase tracking-tighter">Maturing: Ready in {{ now()->diffForHumans($pigeon->hatch_at->addDay(), true) }}</span>
                                </div>
                            @endif
                            </div>

                        @if($totalStats >= $required && $pigeon->level < 100)
                            <button wire:click="levelUp({{ $pigeon->id }})" 
                                    class="bg-yellow-500 text-black font-industrial font-black text-[10px] px-4 py-2 rounded-xl hover:scale-105 transition shadow-lg shadow-yellow-500/20 uppercase tracking-tighter">
                                Rank Up
                            </button>
                        @endif
                    </div>

                    <!-- Grid: Stats & Aesthetics -->
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 text-left">Core Performance</h4>
                            @foreach(['speed' => 'RUN', 'endurance' => 'POW', 'navigation' => 'DIR', 'temperament' => 'MND'] as $stat => $label)
                                <div class="relative">
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-[9px] font-black text-slate-400">{{ $label }}</span>
                                        <span class="text-xs font-black text-white">{{ $pigeon->$stat }} <span class="text-yellow-500 text-[10px] ml-1">{{ $pigeon->stat_grades[$stat] }}</span></span>
                                    </div>
                                    <div class="flex gap-1">
                                        <div class="flex-1 h-1 bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-500 transition-all duration-1000" style="width: {{ ($pigeon->$stat / ($pigeon->level * 10)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 bg-white/5 p-4 rounded-2xl border border-white/5">
                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 text-center">Visual Grade: {{ $pigeon->stat_grades['beauty'] }}</h4>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                @foreach(['eyes' => '👁️', 'beak' => '👃', 'legs' => '🦵', 'feather_quality' => '✨', 'pattern' => '🎨', 'color' => '🌈', 'purity' => '💎'] as $stat => $icon)
                                    <div class="flex flex-col text-left">
                                        <div class="flex justify-between items-center">
                                            <span class="text-[8px] text-slate-500 uppercase font-black truncate">{{ str_replace('_', ' ', $stat) }}</span>
                                            <span class="text-[9px] text-white font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="px-6 py-3 bg-black/40 flex justify-between items-center">
                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest italic">Operational Status: {{ strtoupper($pigeon->status) }}</span>
                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest italic">Age: {{ $ageDays }} Days</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pigeons->links() }}
    </div>
</div>

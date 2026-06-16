<div class="text-slate-300 font-sans" x-data="{}" x-on:pigeon-leveled-up.window="alert('Congratulations! ' + $event.detail.name + ' reached a new rank!')" wire:poll.60s>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-[#b8860b] text-white px-6 py-3 rounded-xl shadow-2xl font-black font-industrial italic animate-bounce border-2 border-white/20">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="err-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-red-800 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial italic border-2 border-white/20">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filter Console -->
    <div class="bg-[#050a0a] p-6 rounded-[2rem] border-2 border-[#b8860b]/20 shadow-2xl mb-8 flex flex-col lg:flex-row gap-6 items-center">
        <div class="flex-1 w-full">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="SEARCH LOFT RECORDS..." 
                   class="w-full bg-black/40 border-2 border-[#b8860b]/10 rounded-2xl p-4 text-white font-black focus:border-[#b8860b] transition-all placeholder-slate-700 font-industrial text-sm italic">
        </div>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <select wire:model.live="typeFilter" class="bg-[#1a2a2a] border-2 border-[#b8860b]/10 rounded-xl px-4 py-3 text-xs font-black text-[#b8860b] uppercase tracking-widest focus:border-[#b8860b] transition-all cursor-pointer">
                <option value="all">ALL TYPES</option>
                <option value="racer">RACER</option>
                <option value="fancy">FANCY</option>
                <option value="highflyer">HIGHFLYER</option>
            </select>

            <select wire:model.live="rarityFilter" class="bg-[#1a2a2a] border-2 border-[#b8860b]/10 rounded-xl px-4 py-3 text-xs font-black text-[#b8860b] uppercase tracking-widest focus:border-[#b8860b] transition-all cursor-pointer">
                <option value="all">ALL RARITIES</option>
                <option value="common">COMMON</option>
                <option value="rare">RARE</option>
                <option value="legendary">LEGENDARY</option>
            </select>

            <select wire:model.live="sortBy" class="bg-[#1a2a2a] border-2 border-[#b8860b]/10 rounded-xl px-4 py-3 text-xs font-black text-[#b8860b] uppercase tracking-widest focus:border-[#b8860b] transition-all cursor-pointer">
                <option value="level">SORT BY LEVEL</option>
                <option value="energy">SORT BY CONDITION</option>
                <option value="speed">SORT BY SPEED</option>
                <option value="beauty">SORT BY APPEARANCE</option>
            </select>
        </div>
    </div>

    <!-- Units Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
        @foreach($pigeons as $pigeon)
            <div class="group relative bg-[#050a0a] rounded-[2.5rem] border-2 border-[#b8860b]/10 hover:border-[#b8860b]/40 transition-all duration-500 overflow-hidden shadow-2xl">
                <!-- ID Card Header -->
                <div class="bg-gradient-to-r from-[#0a1414] to-[#050a0a] p-6 border-b border-[#b8860b]/10">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <!-- Name & Rank -->
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-[#b8860b] text-white font-industrial font-black text-xs px-2 py-0.5 rounded italic shadow-lg">LV.{{ $pigeon->level }}</span>
                                <input type="text" wire:model.lazy="newName.{{ $pigeon->id }}" 
                                       wire:keydown.enter="updateName({{ $pigeon->id }})"
                                       placeholder="{{ $pigeon->name }}" 
                                       class="bg-transparent border-none p-0 text-2xl font-industrial font-black text-white focus:ring-0 w-full placeholder-white/20 italic">
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="text-[10px] font-black uppercase tracking-widest border border-slate-800 text-slate-500 px-3 py-1 rounded-full bg-black/20">{{ $pigeon->type }}</span>
                                <span class="text-[10px] font-black uppercase tracking-widest border border-[#b8860b]/30 text-[#b8860b] px-3 py-1 rounded-full bg-[#b8860b]/5">{{ $pigeon->rarity }}</span>
                                @if($pigeon->income_per_minute > 0)
                                    <span class="text-[10px] font-black uppercase tracking-widest bg-green-900/20 text-green-400 border border-green-500/20 px-3 py-1 rounded-full">+{{ $pigeon->income_per_minute }} 💰/MIN</span>
                                @endif
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $pigeon->gender == 'male' ? 'bg-blue-900/20 text-blue-400 border-blue-500/20' : 'bg-pink-900/20 text-pink-400 border-pink-500/20' }} px-3 py-1 border rounded-full">
                                    {{ $pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                </span>
                            </div>
                        </div>

                        <!-- Vitality Gauge -->
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Condition</span>
                            <div class="relative w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 transform -rotate-90">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" class="text-slate-900" />
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent"
                                            stroke-dasharray="125.6"
                                            stroke-dashoffset="{{ 125.6 * (1 - ($pigeon->energy / 100)) }}"
                                            class="{{ $pigeon->energy > 30 ? 'text-[#b8860b]' : 'text-red-600' }} transition-all duration-1000 shadow-lg" />
                                </svg>
                                <span class="absolute text-[10px] font-black text-white italic font-industrial">{{ $pigeon->energy }}%</span>
                            </div>
                            @if($pigeon->energy < 100)
                                <button wire:click="rest({{ $pigeon->id }})" class="mt-2 text-[8px] font-black bg-[#1a2a2a] hover:bg-[#b8860b] hover:text-white text-slate-400 px-3 py-1 rounded-lg transition border border-[#b8860b]/20 uppercase italic">
                                    Rest (50💰)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Lifecycle Ribbon -->
                    @php
                        $ageDays = $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0;
                        $statusText = 'Adult Bird';
                        if ($pigeon->status === 'chick') $statusText = 'Young Chick';
                        elseif ($pigeon->birth_at->addDays(4)->isFuture()) $statusText = 'Yearling';

                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                        $required = $pigeon->level * 30;
                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                    @endphp
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="bg-[#0a1414] p-4 rounded-2xl border border-[#b8860b]/10">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                                <span class="italic">Loyalty: {{ $pigeon->loyalty }}%</span>
                                <span class="text-[#b8860b] italic">Instinct</span>
                            </div>
                            <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden">
                                <div class="h-full bg-[#b8860b] transition-all duration-700 shadow-[0_0_10px_rgba(184,134,11,0.4)]" style="width: {{ $pigeon->loyalty }}%"></div>
                            </div>
                        </div>
                        <div class="bg-[#0a1414] p-4 rounded-2xl border border-[#b8860b]/10">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                                <span class="italic">Intelligence: {{ $pigeon->intelligence }}</span>
                                <span class="text-indigo-400 italic">Learning</span>
                            </div>
                            <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 transition-all duration-700 shadow-[0_0_10px_rgba(99,102,241,0.4)]" style="width: {{ $pigeon->intelligence }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6 bg-[#0a1414] p-4 rounded-2xl border border-[#b8860b]/10">
                        <div class="flex-1">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 italic">
                                <span>Status: {{ $statusText }}</span>
                                <span>Training: {{ $totalStats }} / {{ $required }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-black/40 rounded-full overflow-hidden">
                                <div class="h-full bg-[#b8860b] transition-all duration-700 shadow-[0_0_10px_rgba(184,134,11,0.4)]" style="width: {{ $progress }}%"></div>
                            </div>
                            @if($pigeon->status === 'chick')
                                <div class="mt-3 flex items-center gap-2 bg-[#b8860b]/10 p-2 rounded-lg border border-[#b8860b]/20">
                                    <svg class="w-3 h-3 text-[#b8860b] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-[8px] font-black text-[#b8860b] uppercase tracking-widest italic">Maturing: Ready in {{ now()->diffForHumans($pigeon->created_at->addDay(), true) }}</span>
                                </div>
                            @endif
                            </div>

                        @if($totalStats >= $required && $pigeon->level < 100)
                            <button wire:click="levelUp({{ $pigeon->id }})" 
                                    class="bg-white text-black font-industrial font-black text-[10px] px-4 py-2 rounded-xl hover:bg-[#b8860b] hover:text-white transition shadow-lg uppercase italic tracking-tighter">
                                Rank Up
                            </button>
                        @endif
                    </div>

                    <!-- Statistics Matrix -->
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 text-left italic">Performance Stats</h4>
                            @foreach(['speed' => 'Speed', 'endurance' => 'Endurance', 'navigation' => 'Navigation', 'temperament' => 'Temperament'] as $stat => $label)
                                <div class="relative">
                                    <div class="flex justify-between items-end mb-1.5">
                                        <span class="text-[9px] font-black text-slate-400 uppercase italic">{{ $label }}</span>
                                        <span class="text-xs font-black text-white italic font-industrial">{{ $pigeon->$stat }} <span class="text-[#b8860b] text-[10px] ml-1">[{{ $pigeon->stat_grades[$stat] }}]</span></span>
                                    </div>
                                    <div class="h-1 bg-black/40 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#b8860b] transition-all duration-1000 shadow-[0_0_5px_rgba(184,134,11,0.3)]" style="width: {{ ($pigeon->$stat / ($pigeon->level * 10)) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 bg-black/30 p-5 rounded-2xl border border-[#b8860b]/10">
                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 text-center italic border-b border-white/5 pb-2">Appearance: <span class="text-white font-industrial ml-1">{{ $pigeon->stat_grades['beauty'] }}</span></h4>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                                @foreach(['eyes' => '👁️', 'beak' => '👃', 'legs' => '🦵', 'feather_quality' => '✨', 'pattern' => '🎨', 'color' => '🌈', 'purity' => '💎'] as $stat => $icon)
                                    @php
                                        $label = match($stat) {
                                            'feather_quality' => 'Feathering',
                                            'purity' => 'Bloodline',
                                            default => ucfirst($stat)
                                        };
                                    @endphp
                                    <div class="flex flex-col text-left">
                                        <div class="flex justify-between items-center border-b border-white/5 pb-1">
                                            <span class="text-[8px] text-slate-500 uppercase font-black italic truncate">{{ $label }}</span>
                                            <span class="text-[9px] text-white font-industrial font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="px-8 py-3 bg-black/60 flex justify-between items-center border-t border-white/5">
                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-[0.2em] italic">Current Duty: {{ strtoupper($pigeon->status) }}</span>
                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-[0.2em] italic">Age: {{ $ageDays }} Days</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pigeons->links() }}
    </div>
</div>

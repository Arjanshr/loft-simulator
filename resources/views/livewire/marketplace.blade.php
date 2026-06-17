<div class="space-y-8 font-sans text-slate-300">
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

    <div class="flex flex-col xl:flex-row gap-8">
        <!-- Sidebar Filters: The Fancier's Desk -->
        <aside class="xl:w-80 space-y-6">
            <div class="parchment-panel rounded-3xl p-8 border-2 border-aviary-brass/10 shadow-2xl sticky top-8">
                <h3 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-8 border-b border-aviary-brass/20 pb-4">Filters</h3>
                
                <div class="space-y-8">
                    <!-- Search -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-aviary-feather/60 uppercase tracking-[0.2em] italic">Search Registry</label>
                        <input wire:model.live="search" type="text" placeholder="Bird Name..." 
                               class="w-full bg-aviary-oak/50 border-2 border-aviary-brass/10 rounded-xl p-4 text-white font-industrial italic focus:border-aviary-blue focus:ring-0 transition-all placeholder-aviary-feather/30">
                    </div>

                    <!-- Type -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-aviary-feather/60 uppercase tracking-[0.2em] italic">Bird Strain</label>
                        <select wire:model.live="type" class="w-full bg-aviary-oak/50 border-2 border-aviary-brass/10 rounded-xl p-4 text-white font-industrial italic focus:border-aviary-blue focus:ring-0 transition-all">
                            <option value="">All Strains</option>
                            <option value="racer">Racer</option>
                            <option value="fancy">Fancy</option>
                            <option value="highflyer">Highflyer</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-aviary-feather/60 uppercase tracking-[0.2em] italic">Gender</label>
                        <div class="flex gap-2">
                            @foreach(['' => 'All', 'male' => '♂ Cock', 'female' => '♀ Hen'] as $val => $label)
                                <button wire:click="$set('gender', '{{ $val }}')" 
                                        class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border-2 {{ $gender === $val ? 'bg-aviary-blue border-aviary-blue text-white shadow-lg' : 'bg-aviary-oak/30 border-aviary-brass/10 text-aviary-feather/50 hover:border-aviary-brass/30' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-aviary-feather/60 uppercase tracking-[0.2em] italic">Price Range (💰)</label>
                        <div class="flex items-center gap-3">
                            <input wire:model.live="minPrice" type="number" placeholder="Min" class="w-full bg-aviary-oak/50 border-2 border-aviary-brass/10 rounded-xl p-3 text-white text-sm font-mono focus:border-aviary-blue focus:ring-0 placeholder-aviary-feather/30">
                            <span class="text-aviary-feather/30">—</span>
                            <input wire:model.live="maxPrice" type="number" placeholder="Max" class="w-full bg-aviary-oak/50 border-2 border-aviary-brass/10 rounded-xl p-3 text-white text-sm font-mono focus:border-aviary-blue focus:ring-0 placeholder-aviary-feather/30">
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content: The Auction Floor -->
        <div class="flex-1 space-y-12">
            <!-- My Listings -->
            <div class="parchment-panel rounded-[3rem] p-8 border-2 border-aviary-brass/10 shadow-xl overflow-hidden relative">
                <div class="absolute top-0 right-0 p-8 opacity-[0.03] text-8xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">My Ledger</div>
                <livewire:my-listings />
            </div>

            <!-- Global Listings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-8">
                @foreach($listings as $listing)
                    <div class="group relative bg-aviary-timber/40 rounded-[2.5rem] border-2 border-aviary-brass/10 p-1 hover:border-aviary-blue/40 transition-all duration-500 shadow-2xl galvanized-border">
                        <div class="bg-aviary-oak rounded-[2.3rem] p-6 md:p-8 flex flex-col h-full border border-white/5 relative z-10 overflow-hidden">
                            <!-- Pedigree Header -->
                            <div class="absolute top-0 left-0 w-full h-12 bg-gradient-to-b from-aviary-brass/10 to-transparent flex items-center justify-center">
                                <span class="text-[8px] font-black text-aviary-brass uppercase tracking-[0.5em] italic">Official Pedigree Certificate</span>
                            </div>

                            <div class="mt-8 flex justify-between items-start mb-10">
                                <div class="space-y-4 max-w-[60%]">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-aviary-blue text-white text-[9px] font-black px-2 py-0.5 rounded italic">LV.{{ $listing->pigeon->level }}</span>
                                        <h3 class="text-xl md:text-2xl font-industrial font-black text-white italic tracking-tight uppercase truncate leading-none">{{ $listing->pigeon->name }}</h3>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="text-[8px] font-black bg-aviary-timber text-aviary-feather px-3 py-1 rounded-lg border border-aviary-brass/20 uppercase tracking-widest">{{ $listing->pigeon->type }}</span>
                                        <span class="text-[8px] font-black {{ $listing->pigeon->rarity === 'legendary' ? 'bg-aviary-brass text-white' : 'bg-black/40 text-aviary-brass' }} px-3 py-1 rounded-lg border border-aviary-brass/20 uppercase tracking-widest">{{ $listing->pigeon->rarity }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[8px] font-black text-aviary-feather/50 uppercase block mb-1 tracking-widest italic">Current Bid</span>
                                    <span class="text-2xl md:text-3xl font-industrial font-black text-aviary-brass italic">{{ number_format($listing->price) }}💰</span>
                                </div>
                            </div>

                            <!-- Stat Log -->
                            <div class="bg-black/40 rounded-2xl p-6 border border-aviary-brass/10 mb-8 font-mono relative group-hover:border-aviary-blue/30 transition-colors">
                                <div class="absolute -top-3 left-4 bg-aviary-oak px-3 text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest">Specifications Log</div>
                                <div class="space-y-4 mt-2">
                                    @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP', 'intelligence' => 'INT'] as $stat => $abbr)
                                        <div class="flex items-center gap-4">
                                            <span class="text-[10px] text-aviary-feather/40 w-8">{{ $abbr }}</span>
                                            <div class="flex-1 h-1.5 bg-black/60 rounded-full overflow-hidden">
                                                <div class="h-full {{ $stat === 'intelligence' ? 'bg-aviary-blue' : 'bg-aviary-brass' }} transition-all duration-1000" style="width: {{ ($listing->pigeon->$stat / ($listing->pigeon->level * 10 ?: 10)) * 100 }}%"></div>
                                            </div>
                                            <span class="text-xs text-white font-bold w-6 text-right">{{ $listing->pigeon->$stat }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Technical Details -->
                            <div class="grid grid-cols-2 gap-4 mb-10 text-[9px] font-black uppercase tracking-widest text-aviary-feather/60">
                                <div class="flex justify-between border-b border-aviary-brass/10 pb-2">
                                    <span>GENDER:</span> 
                                    <span class="{{ $listing->pigeon->gender == 'male' ? 'text-aviary-blue' : 'text-aviary-rose' }} italic">
                                        {{ $listing->pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                    </span>
                                </div>
                                <div class="flex justify-between border-b border-aviary-brass/10 pb-2">
                                    <span>GRADE:</span> 
                                    <span class="text-white italic">{{ $listing->pigeon->stat_grades['beauty'] }} pts</span>
                                </div>
                            </div>
                            
                            <!-- Timer & Action -->
                            <div class="mt-auto pt-6 border-t border-aviary-brass/10">
                                @php
                                    $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                                    $isExpired = $remainingSecs <= 0;
                                @endphp
                                <div class="flex justify-between items-center px-2 mb-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full {{ $isExpired ? 'bg-red-600' : 'bg-aviary-blue animate-pulse shadow-[0_0_8px_#3b82f6]' }}"></div>
                                        <span class="text-[9px] font-black uppercase tracking-widest {{ $isExpired ? 'text-red-500' : 'text-aviary-feather/60' }} italic">
                                            {{ $isExpired ? 'Expired' : 'Active' }}
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-mono font-bold text-white uppercase italic">
                                        {{ $isExpired ? '00:00:00' : gmdate("H:i:s", $remainingSecs) }}
                                    </span>
                                </div>

                                <button wire:click="buy({{ $listing->id }})" 
                                        @if($isExpired) disabled @endif
                                        class="w-full py-5 {{ $isExpired ? 'bg-aviary-timber text-slate-600 cursor-not-allowed' : 'bg-aviary-brass hover:bg-aviary-blue text-white active:scale-[0.98]' }} font-industrial font-black text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-[0.2em] relative overflow-hidden group/btn">
                                    <span class="relative z-10">Purchase Specimen</span>
                                    <div class="absolute inset-0 bg-aviary-blue translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($listings->isEmpty())
                <div class="py-40 text-center border-2 border-dashed border-aviary-brass/20 rounded-[3rem] bg-aviary-oak/20">
                    <div class="text-6xl mb-8 opacity-20 trophy-gold">📜</div>
                    <p class="text-lg font-industrial font-black text-aviary-feather/30 uppercase tracking-[0.5em] italic">No specimens found in the current registry</p>
                </div>
            @endif
        </div>
    </div>
</div>

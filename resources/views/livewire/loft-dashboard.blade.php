<div class="space-y-12 font-sans text-slate-300">
    @if($showCreateForm)
        <div class="max-w-md mx-auto parchment-panel p-10 rounded-[3rem] border-t-8 border-t-aviary-brass text-center border-2 border-aviary-brass/20 shadow-2xl">
            <h2 class="text-4xl font-industrial font-black text-white mb-4 uppercase italic">Loft Registration</h2>
            <p class="text-aviary-feather/60 mb-8 font-bold uppercase tracking-widest text-xs italic">Registry sequence required to begin management.</p>
            <form wire:submit.prevent="createLoft" class="space-y-6">
                <input wire:model="loftName" class="w-full bg-aviary-oak/40 border-2 border-aviary-brass/10 rounded-2xl p-5 text-white text-center font-black focus:border-aviary-blue transition-all placeholder-aviary-feather/20 font-industrial italic" type="text" placeholder="LOFT IDENTIFIER">
                @error('loftName') <span class="text-red-500 text-xs font-black block uppercase tracking-tighter">{{ $message }}</span> @enderror
                <button type="submit" class="w-full bg-aviary-brass text-white font-industrial font-black py-5 rounded-2xl hover:bg-aviary-blue hover:text-white transition shadow-xl uppercase italic tracking-widest text-xl">Register Loft</button>
            </form>
        </div>
    @elseif($loft)
        <!-- Dashboard Hero: The Registry Plate -->
        <div class="relative overflow-hidden parchment-panel rounded-[2.5rem] md:rounded-[4rem] border-2 border-aviary-brass/20 p-6 md:p-12 shadow-2xl galvanized-border">
            <div class="absolute top-0 right-0 p-4 md:p-10 opacity-[0.03] text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none text-aviary-brass uppercase">
                {{ $loft->name }}
            </div>
            
            <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-16">
                <div class="text-center lg:text-left">
                    <span class="text-aviary-brass font-industrial font-black text-[10px] md:text-sm tracking-[0.4em] uppercase mb-3 block italic">Official Registry</span>
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-industrial font-black text-white italic uppercase tracking-tighter leading-tight md:leading-none mb-6 drop-shadow-2xl">{{ $loft->name }}</h1>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                        <div class="px-6 py-2 bg-aviary-blue text-white font-industrial font-black text-xs md:text-base italic rounded-xl shadow-lg border border-white/20">GRADE {{ $loft->level }}</div>
                        <div class="flex items-center gap-4 bg-black/30 px-5 py-2 rounded-xl border border-aviary-brass/10">
                            <div class="h-2 w-24 md:w-40 bg-aviary-oak rounded-full overflow-hidden">
                                @php
                                    $nextLevel = $loft->level + 1;
                                    $xpRequired = $nextLevel * $nextLevel * 100;
                                    $progress = min(100, ($loft->xp / ($xpRequired ?: 1)) * 100);
                                @endphp
                                <div class="h-full bg-aviary-blue shadow-[0_0_15px_#3b82f6]" style="width: {{ $progress }}%"></div>
                            </div>
                            <span class="text-[9px] md:text-[11px] font-mono font-bold text-aviary-feather/60 uppercase tracking-widest italic whitespace-nowrap">{{ number_format($loft->xp) }} / {{ number_format($xpRequired) }} EXP</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-8 md:gap-12 w-full lg:w-auto">
                    <div class="flex flex-col gap-4">
                        <div class="text-center bg-black/40 p-6 md:p-8 rounded-3xl border border-aviary-brass/20 min-w-[180px] shadow-inner">
                            <div class="text-4xl md:text-6xl font-industrial font-black text-aviary-brass italic">{{ number_format($totalValue) }}</div>
                            <div class="text-[9px] md:text-[11px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] mt-3 italic">Loft Value (💎)</div>
                        </div>
                    </div>
                    
                    @php
                        $upgradeCost = ($loft->level + 1) * 500;
                        $canAfford   = $loft->coins >= $upgradeCost;
                    @endphp
                    @if($loft->xp >= $xpRequired)
                        <div class="flex flex-col items-center gap-3 self-center">
                            <button wire:click="upgrade"
                                    class="w-full sm:w-auto font-industrial font-black px-10 py-5 rounded-[2rem] transition shadow-2xl active:scale-95 uppercase italic tracking-widest text-sm md:text-base border-2
                                        {{ $canAfford ? 'bg-aviary-brass text-white hover:bg-aviary-blue border-white/10' : 'bg-red-900/40 text-red-300 border-red-500/30 cursor-not-allowed opacity-70' }}">
                                Upgrade Loft
                            </button>
                            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest italic
                                        {{ $canAfford ? 'text-emerald-400' : 'text-red-400' }}">
                                <span>{{ $canAfford ? '✔' : '✘' }}</span>
                                <span>Cost: {{ number_format($upgradeCost) }} 💰</span>
                                @if(!$canAfford)
                                    <span class="text-aviary-feather/40">· Need {{ number_format($upgradeCost - $loft->coins) }} more</span>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Not enough XP yet: still show the cost so user knows what's coming --}}
                        <div class="self-center text-center bg-black/30 px-6 py-4 rounded-2xl border border-aviary-brass/10">
                            <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest italic mb-1">Next Upgrade Cost</p>
                            <p class="font-mono font-bold text-aviary-brass text-lg">{{ number_format($upgradeCost) }} 💰</p>
                            <p class="text-[8px] font-black uppercase tracking-widest italic mt-1
                                      {{ $canAfford ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $canAfford ? '✔ Funds Ready' : '✘ Need ' . number_format($upgradeCost - $loft->coins) . ' more' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <livewire:stray-manager />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
            <!-- Operational Summary: Loft Census -->
            <div class="lg:col-span-2 space-y-8 md:space-y-12">
                <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-aviary-brass/20 to-transparent"></div>
                    <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span> Loft Census
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                        @foreach([
                            ['Total Stock', $loft->pigeons->count(), 'text-white'],
                            ['Racers', $loft->pigeons->where('type', 'racer')->count(), 'text-aviary-blue'],
                            ['Fancy', $loft->pigeons->where('type', 'fancy')->count(), 'text-indigo-400'],
                            ['Highflyers', $loft->pigeons->where('type', 'highflyer')->count(), 'text-green-500']
                        ] as [$label, $count, $color])
                            <div class="bg-black/30 p-5 rounded-2xl border border-aviary-brass/5 text-center group hover:border-aviary-blue/30 transition-all">
                                <span class="block text-2xl md:text-4xl font-industrial font-black {{ $color }} mb-1 italic">{{ $count }}</span>
                                <span class="text-[8px] md:text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest italic">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Strategic Assets: Champion Registry -->
                <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-xl">
                    <div class="flex justify-between items-center mb-8 border-b border-aviary-brass/10 pb-4">
                        <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest">Champion Registry</h2>
                        <a href="{{ route('pigeons.index') }}" class="text-[9px] md:text-[11px] font-black text-aviary-blue uppercase tracking-[0.2em] hover:text-white transition-colors italic">Manage All →</a>
                    </div>
                    <div class="space-y-4 md:space-y-6">
                        @foreach($loft->pigeons->sortByDesc('total_score')->take(3) as $p)
                            <div class="flex justify-between items-center bg-black/40 p-5 rounded-2xl border border-aviary-brass/5 hover:border-aviary-blue/20 transition-all group">
                                <div class="flex items-center gap-4 md:gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-aviary-blue/10 flex items-center justify-center font-industrial font-black text-aviary-blue text-xs italic border border-aviary-blue/20">
                                        LV.{{ $p->level }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-industrial font-black text-white uppercase text-sm md:text-lg tracking-widest truncate max-w-[150px] md:max-w-none italic">{{ $p->name }}</span>
                                        <x-pigeon.registry-meta :pigeon="$p" size="sm" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest italic mr-2">Score</span>
                                    <span class="font-mono font-bold text-aviary-brass text-sm md:text-xl italic">{{ number_format($p->total_score, 1) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Side Desk -->
            <div class="space-y-8 md:space-y-12">
                <!-- Status Module -->
                <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-xl">
                    <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-8 border-b border-aviary-brass/10 pb-4">Field Reports</h2>
                    <div class="space-y-6">
                        @php
                            $breedingCount = $loft->breedingRecords->count();
                        @endphp
                        @if($breedingCount > 0)
                            <div class="bg-aviary-blue/5 p-5 rounded-2xl border border-aviary-blue/10">
                                <p class="text-aviary-blue font-black text-[11px] md:text-xs uppercase tracking-[0.2em] animate-pulse flex items-center gap-2">
                                    <span class="w-2 h-2 bg-aviary-blue rounded-full"></span> Nesting Active
                                </p>
                                <p class="text-[9px] md:text-[11px] text-aviary-feather/60 mt-2 uppercase font-bold italic">{{ $breedingCount }} pairs currently incubating.</p>
                            </div>
                        @endif
                        
                        <div class="bg-black/30 p-5 rounded-2xl border border-aviary-brass/10">
                            <p class="text-white font-black text-[11px] md:text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span> Flight Status
                            </p>
                            <p class="text-[9px] md:text-[11px] text-aviary-feather/60 mt-2 uppercase font-bold italic">{{ $loft->pigeons->where('status', 'racing')->count() }} birds in competition.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Access: Tack Board -->
                <div class="grid grid-cols-2 gap-6">
                    <a href="{{ route('tournaments') }}" class="bg-aviary-oak/60 hover:bg-aviary-blue group p-6 rounded-[2rem] border-2 border-aviary-brass/10 transition-all text-center shadow-xl galvanized-border">
                        <span class="block text-3xl mb-3 group-hover:scale-110 transition-transform">🏁</span>
                        <span class="text-[9px] font-black text-aviary-feather/40 group-hover:text-white uppercase tracking-[0.3em] italic">Racing</span>
                    </a>
                    <a href="{{ route('breeding.center') }}" class="bg-aviary-oak/60 hover:bg-aviary-blue group p-6 rounded-[2rem] border-2 border-aviary-brass/10 transition-all text-center shadow-xl galvanized-border">
                        <span class="block text-3xl mb-3 group-hover:scale-110 transition-transform">🥚</span>
                        <span class="text-[9px] font-black text-aviary-feather/40 group-hover:text-white uppercase tracking-[0.3em] italic">Breeding</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

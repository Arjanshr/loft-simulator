<div class="space-y-12 font-sans text-slate-300">
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

    <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden galvanized-border">
        <div class="absolute top-0 right-0 p-4 md:p-8 opacity-[0.03] text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter text-aviary-brass">Nesting</div>
        
        <div class="relative z-10">
            <!-- Header: Hatchery Status -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8 mb-12 bg-aviary-oak/40 p-6 md:p-8 rounded-[2.5rem] border border-aviary-brass/10 shadow-inner">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight mb-2">The Hatchery</h2>
                    <p class="text-aviary-feather/40 text-[9px] md:text-[11px] font-black uppercase tracking-[0.3em] italic">Loft Breeding Station • Grade {{ Auth::user()->loft->level }} Access</p>
                </div>
                <div class="flex items-center gap-6 md:gap-12">
                    <div class="text-center">
                        <span class="text-3xl md:text-5xl font-industrial font-black text-aviary-brass trophy-gold">{{ $pairs->count() }}</span>
                        <span class="block text-[8px] md:text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mt-1 italic whitespace-nowrap">Active Nests</span>
                    </div>
                    <div class="w-[1px] h-10 md:h-16 bg-aviary-brass/20"></div>
                    <div class="text-center">
                        <span class="text-3xl md:text-5xl font-industrial font-black text-aviary-feather/60 italic">{{ Auth::user()->loft->level }}</span>
                        <span class="block text-[8px] md:text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mt-1 italic whitespace-nowrap">Max Capacity</span>
                    </div>
                </div>
            </div>

            @if($pairs->count() < Auth::user()->loft->level)
                <!-- Pairing Station -->
                <div class="flex items-center gap-4 mb-8 px-2">
                    <div class="w-12 h-1 bg-aviary-blue rounded-full shadow-[0_0_10px_#3b82f6]"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">New Pair Registry</h3>
                    <div class="flex-1 h-[1px] bg-aviary-brass/10"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
                    <form wire:submit="createPair" class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 items-end bg-aviary-oak/60 p-6 md:p-8 rounded-[2rem] border border-aviary-brass/10 shadow-xl galvanized-border">
                        <div class="space-y-3">
                            <label class="block text-[9px] md:text-[11px] font-black text-aviary-blue uppercase tracking-widest ml-1 italic">Sire (♂ Cock)</label>
                            <select wire:model="maleId" class="w-full bg-aviary-oak/80 border-2 border-aviary-blue/20 rounded-2xl p-4 text-white font-mono text-sm focus:border-aviary-blue transition-all appearance-none cursor-pointer italic uppercase">
                                <option value="">SELECT MATURE COCK</option>
                                @foreach($males as $p) <option value="{{ $p->id }}">{{ $p->name }} [LV.{{ $p->level }}]</option> @endforeach
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[9px] md:text-[11px] font-black text-aviary-rose uppercase tracking-widest ml-1 italic">Dam (♀ Hen)</label>
                            <select wire:model="femaleId" class="w-full bg-aviary-oak/80 border-2 border-aviary-rose/20 rounded-2xl p-4 text-white font-mono text-sm focus:border-aviary-rose transition-all appearance-none cursor-pointer italic uppercase">
                                <option value="">SELECT MATURE HEN</option>
                                @foreach($females as $p) <option value="{{ $p->id }}">{{ $p->name }} [LV.{{ $p->level }}]</option> @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full py-4 bg-aviary-brass hover:bg-aviary-blue text-white font-industrial font-black text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-widest border border-white/10 group">
                            <span class="group-hover:scale-105 transition-transform block">Register Pair</span>
                        </button>
                    </form>

                    <div class="bg-aviary-timber/30 border border-aviary-brass/20 rounded-[2rem] p-6 space-y-6 shadow-inner">
                        <h4 class="text-[11px] font-black text-aviary-brass uppercase tracking-widest italic flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-aviary-brass"></span> Fancier's Note
                        </h4>
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <span class="text-aviary-blue font-mono font-bold text-sm">I</span>
                                <p class="text-[9px] text-aviary-feather/60 leading-relaxed font-bold uppercase italic">Incubation: 24h of strict parental care.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="text-aviary-blue font-mono font-bold text-sm">II</span>
                                <p class="text-[9px] text-aviary-feather/60 leading-relaxed font-bold uppercase italic">Maturation: Chicks transition to Yearlings on Day 2.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="text-aviary-blue font-mono font-bold text-sm">III</span>
                                <p class="text-[9px] text-aviary-feather/60 leading-relaxed font-bold uppercase italic">Duty: Full flight capability attained on Day 4.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-950/10 p-10 rounded-[3rem] border-2 border-dashed border-red-500/20 text-center mb-12">
                    <p class="font-industrial font-black text-red-500/60 text-lg uppercase italic tracking-widest">Hatchery capacity reached. Expand your Loft to register more nests.</p>
                </div>
            @endif

            <!-- Active Nests -->
            <div class="mt-16">
                <div class="flex items-center gap-4 mb-10 px-2">
                    <div class="w-12 h-1 bg-aviary-brass rounded-full shadow-[0_0_10px_#b8860b]"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Nesting Registry</h3>
                    <div class="flex-1 h-[1px] bg-aviary-brass/10"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                    @foreach($pairs as $pair)
                        @php
                            $record = $breedingRecords->where('sire_id', $pair->male_id)->where('dam_id', $pair->female_id)->first();
                            $isNursing = $pair->male->status === 'nursing' || $pair->female->status === 'nursing';
                        @endphp
                        <div class="bg-aviary-oak/60 rounded-[3rem] border-2 border-aviary-brass/10 p-6 md:p-8 hover:border-aviary-blue/30 transition-all duration-500 relative overflow-hidden shadow-2xl group galvanized-border">
                            <div class="absolute top-0 left-0 w-full h-1 bg-aviary-brass/5 group-hover:bg-aviary-blue/20 transition-colors"></div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-10 gap-6">
                                <div class="w-full sm:w-auto">
                                    <div class="flex items-center gap-2 mb-3">
                                        @if($record)
                                            <span class="w-1.5 h-1.5 rounded-full bg-aviary-brass animate-pulse shadow-[0_0_8px_#b8860b]"></span>
                                            <span class="text-[9px] font-black text-aviary-brass uppercase tracking-[0.2em] italic">Incubation Phase</span>
                                        @elseif($isNursing)
                                            <span class="w-1.5 h-1.5 rounded-full bg-aviary-blue shadow-[0_0_8px_#3b82f6]"></span>
                                            <span class="text-[9px] font-black text-aviary-blue uppercase tracking-[0.2em] italic">Nursing Brood</span>
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                            <span class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-[0.2em] italic">Nesting Standby</span>
                                        @endif
                                    </div>
                                    <h4 class="text-xl md:text-3xl font-industrial font-black text-white italic tracking-tighter uppercase leading-none">
                                        {{ $pair->male->name }} <span class="text-aviary-brass text-xs mx-2">×</span> {{ $pair->female->name }}
                                    </h4>
                                    <div class="mt-3 flex gap-2">
                                        <span class="text-[8px] font-mono text-aviary-feather/30 uppercase">Sire LV.{{ $pair->male->level }}</span>
                                        <span class="text-[8px] font-mono text-aviary-feather/30 uppercase">•</span>
                                        <span class="text-[8px] font-mono text-aviary-feather/30 uppercase">Dam LV.{{ $pair->female->level }}</span>
                                    </div>
                                </div>
                                @if($record)
                                    @php
                                        $hatchTime = $record->eggs_laid_at->addDay();
                                        $remaining = now()->diffInSeconds($hatchTime, false);
                                    @endphp
                                    <div class="text-left sm:text-right bg-black/40 sm:bg-transparent p-5 sm:p-0 rounded-2xl border border-aviary-brass/10 sm:border-none w-full sm:w-auto" wire:key="timer-{{ $record->id }}">
                                        @if($remaining > 0)
                                            <span class="text-[9px] font-black text-aviary-brass block uppercase mb-2 italic">Hatch Sequence</span>
                                            <span class="text-xl md:text-3xl font-mono font-bold text-white tracking-widest" wire:poll.1s>
                                                {{ gmdate("H:i:s", $remaining) }}
                                            </span>
                                        @else
                                            <button wire:click="hatch({{ $record->id }})" class="bg-aviary-blue text-white px-8 py-4 rounded-2xl font-industrial font-black text-[10px] hover:bg-aviary-brass transition-all animate-bounce shadow-2xl uppercase italic border border-white/20">
                                                Finalize Hatch
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-aviary-brass/10">
                                @php
                                    $readyToBreedTime = $pair->created_at->addHours(6);
                                    $timeUntilReady = now()->diffInSeconds($readyToBreedTime, false);
                                @endphp

                                @if(!$record)
                                    @if($isNursing)
                                        @php
                                            $nursingEndTime = $pair->male->updated_at->addDay();
                                            $nursingRemaining = now()->diffInSeconds($nursingEndTime, false);
                                        @endphp
                                        <div class="flex-1 bg-aviary-blue/5 p-5 rounded-2xl border border-aviary-blue/10 text-center">
                                            <span class="text-[9px] font-black text-aviary-blue uppercase block mb-2 italic">Parental Care Required</span>
                                            <span class="text-lg font-mono font-bold text-white tracking-widest">{{ $nursingRemaining > 0 ? gmdate("H:i:s", $nursingRemaining) : 'FINALIZING...' }}</span>
                                        </div>
                                    @elseif($timeUntilReady > 0)
                                        <div class="w-full bg-aviary-oak/40 p-5 rounded-2xl border border-aviary-brass/10 text-center shadow-inner">
                                            <span class="text-[9px] font-black text-aviary-feather/40 uppercase block mb-2 italic">Bonding In Progress</span>
                                            <span class="text-lg font-mono font-bold text-white tracking-widest">{{ gmdate("H:i:s", $timeUntilReady) }}</span>
                                        </div>
                                    @else
                                        <button wire:click="breedPair({{ $pair->id }})" 
                                                class="flex-1 py-5 bg-aviary-brass hover:bg-aviary-blue text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl uppercase italic tracking-widest border border-white/10 group">
                                            <span class="group-hover:scale-105 transition-transform block">Initiate Breeding (100💰)</span>
                                        </button>
                                    @endif
                                    <button wire:click="disband({{ $pair->id }})" 
                                            class="py-5 px-10 bg-aviary-timber/40 hover:bg-red-900 text-aviary-feather/60 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all border border-aviary-brass/10 uppercase italic">
                                        Disband
                                    </button>
                                @else
                                    <div class="flex-1 bg-black/40 p-6 rounded-[2rem] border border-aviary-brass/20 flex items-center justify-center shadow-inner">
                                        <p class="text-[10px] md:text-xs font-black text-aviary-feather/30 uppercase tracking-[0.2em] italic text-center">Parents currently occupied in the nest</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($pairs->isEmpty())
                        <div class="col-span-full py-24 border-2 border-dashed border-aviary-brass/10 rounded-[4rem] text-center bg-aviary-oak/10">
                            <div class="text-6xl mb-8 opacity-10">🥚</div>
                            <p class="font-industrial font-black text-aviary-feather/20 text-xl md:text-3xl uppercase italic tracking-[0.3em]">No Active Pairs Registered</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

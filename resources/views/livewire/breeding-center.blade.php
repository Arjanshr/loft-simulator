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

    <div class="bg-[#050a0a] p-6 md:p-10 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 md:p-8 opacity-5 text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter text-[#b8860b]">Nesting</div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8 mb-8 md:mb-12 bg-black/40 p-6 md:p-8 rounded-[2rem] border border-[#b8860b]/10">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight mb-2">Loft Nesting</h2>
                    <p class="text-slate-500 text-[8px] md:text-[10px] font-black uppercase tracking-[0.3em] italic">Capacity Link: Level {{ Auth::user()->loft->level }} Station</p>
                </div>
                <div class="flex items-center gap-4 md:gap-8">
                    <div class="text-center">
                        <span class="text-3xl md:text-5xl font-industrial font-black text-[#b8860b]">{{ $pairs->count() }}</span>
                        <span class="block text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1 italic whitespace-nowrap">Active Pairs</span>
                    </div>
                    <div class="w-[1px] h-10 md:h-16 bg-[#b8860b]/20"></div>
                    <div class="text-center text-slate-700">
                        <span class="text-3xl md:text-5xl font-industrial font-black italic">{{ Auth::user()->loft->level }}</span>
                        <span class="block text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1 italic whitespace-nowrap">Max Nests</span>
                    </div>
                </div>
            </div>

            @if($pairs->count() < Auth::user()->loft->level)
                <div class="flex items-center gap-4 mb-6 md:mb-10 px-2">
                    <div class="w-8 md:w-12 h-1 bg-[#b8860b] rounded-full"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Pairing Station</h3>
                    <div class="flex-1 h-[1px] bg-[#b8860b]/10"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-8">
                    <form wire:submit="createPair" class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-end bg-[#0a1414] p-6 md:p-8 rounded-[2rem] border border-[#b8860b]/10 shadow-xl">
                        <div class="space-y-2">
                            <label class="block text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Sire Selection (♂)</label>
                            <select wire:model="maleId" class="w-full bg-black/50 border-2 border-slate-800 rounded-2xl p-3 md:p-4 text-white font-bold text-xs md:text-base focus:border-[#b8860b] transition-all appearance-none cursor-pointer italic uppercase">
                                <option value="">SELECT MATURE COCK</option>
                                @foreach($males as $p) <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }}]</option> @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Dam Selection (♀)</label>
                            <select wire:model="femaleId" class="w-full bg-black/50 border-2 border-slate-800 rounded-2xl p-3 md:p-4 text-white font-bold text-xs md:text-base focus:border-[#b8860b] transition-all appearance-none cursor-pointer italic uppercase">
                                <option value="">SELECT MATURE HEN</option>
                                @foreach($females as $p) <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }}]</option> @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full py-4 bg-[#b8860b] hover:bg-white hover:text-black text-white font-industrial font-black text-xs md:text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-widest">
                            Form Breeding Pair
                        </button>
                    </form>

                    <div class="bg-[#1a2a2a] border border-[#b8860b]/20 rounded-[2rem] p-6 space-y-4">
                        <h4 class="text-[10px] font-black text-[#b8860b] uppercase tracking-widest italic flex items-center gap-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Bird Lifecycle
                        </h4>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <span class="text-[#b8860b] font-bold text-xs">01</span>
                                <p class="text-[8px] text-slate-400 leading-relaxed font-bold uppercase italic">Incubation: 24h of parental care required in the nest.</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-[#b8860b] font-bold text-xs">02</span>
                                <p class="text-[8px] text-slate-400 leading-relaxed font-bold uppercase italic">Hatching: Birds move to loft as "Chicks" for 24h.</p>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-[#b8860b] font-bold text-xs">03</span>
                                <p class="text-[8px] text-slate-400 leading-relaxed font-bold uppercase italic">Active Unit: At 48h total age, birds are ready to train.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-950/20 p-6 md:p-8 rounded-[2rem] border-2 border-dashed border-red-500/30 text-center">
                    <p class="font-industrial font-black text-red-500 text-base md:text-lg uppercase italic tracking-widest">Max capacity reached. System upgrade required.</p>
                </div>
            @endif

            <div class="mt-12 md:mt-16">
                <div class="flex items-center gap-4 mb-6 md:mb-10 px-2">
                    <div class="w-8 md:w-12 h-1 bg-[#b8860b] rounded-full"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Registry: Active Pairs</h3>
                    <div class="flex-1 h-[1px] bg-[#b8860b]/10"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
                    @foreach($pairs as $pair)
                            @php
                                $record = $breedingRecords->where('sire_id', $pair->male_id)->where('dam_id', $pair->female_id)->first();
                                $isNursing = $pair->male->status === 'nursing' || $pair->female->status === 'nursing';
                            @endphp
                            <div class="bg-[#0a1414] rounded-[2.5rem] border-2 border-[#b8860b]/10 p-6 md:p-8 hover:border-[#b8860b]/30 transition-all duration-300 relative overflow-hidden shadow-2xl group">
                                <div class="absolute top-0 left-0 w-full h-1 bg-[#b8860b]/5 group-hover:bg-[#b8860b]/20 transition-colors"></div>
                                
                                <div class="flex flex-col sm:flex-row justify-between items-start mb-8 gap-4">
                                    <div class="w-full sm:w-auto">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($record)
                                                <span class="w-2 h-2 rounded-full bg-[#b8860b] animate-pulse"></span>
                                                <span class="text-[8px] font-black text-[#b8860b] uppercase tracking-[0.2em] italic">Incubating</span>
                                            @elseif($isNursing)
                                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                <span class="text-[8px] font-black text-blue-500 uppercase tracking-[0.2em] italic">Nursing Chicks</span>
                                            @else
                                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Station Standby</span>
                                            @endif
                                        </div>
                                        <h4 class="text-xl md:text-2xl font-industrial font-black text-white italic tracking-tighter uppercase truncate max-w-[15rem]">
                                            {{ $pair->male->name }} <span class="text-[#b8860b] text-xs mx-1">&</span> {{ $pair->female->name }}
                                        </h4>
                                    </div>
                                    @if($record)
                                        @php
                                            $hatchTime = $record->eggs_laid_at->addDay();
                                            $remaining = now()->diffInSeconds($hatchTime, false);
                                        @endphp
                                        <div class="text-left sm:text-right bg-black/40 sm:bg-transparent p-4 sm:p-0 rounded-2xl border border-white/5 sm:border-none w-full sm:w-auto" wire:key="timer-{{ $record->id }}">
                                            @if($remaining > 0)
                                                <span class="text-[7px] md:text-[8px] font-black text-[#b8860b] block uppercase mb-1 italic">Hatch Sequence</span>
                                                <span class="text-lg md:text-xl font-industrial font-black text-white tracking-widest" wire:poll.1s>
                                                    {{ gmdate("H:i:s", $remaining) }}
                                                </span>
                                            @else
                                                <button wire:click="hatch({{ $record->id }})" class="bg-[#b8860b] text-white px-6 py-2.5 rounded-xl font-industrial font-black text-[10px] hover:bg-white hover:text-black transition-all animate-bounce shadow-lg uppercase italic">
                                                    Welcome Chicks
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            <div class="flex flex-col sm:flex-row gap-3">
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
                                        <div class="flex-1 bg-blue-900/10 p-4 rounded-2xl border border-blue-500/20 text-center">
                                            <span class="text-[7px] md:text-[8px] font-black text-blue-400 uppercase block mb-1 italic">Parental Care Phase</span>
                                            <span class="text-sm font-industrial font-black text-white tracking-widest">{{ $nursingRemaining > 0 ? gmdate("H:i:s", $nursingRemaining) : 'FINALIZING...' }}</span>
                                        </div>
                                    @elseif($timeUntilReady > 0)
                                        <div class="w-full bg-black/40 p-4 rounded-2xl border border-white/5 text-center">
                                            <span class="text-[7px] md:text-[8px] font-black text-slate-500 uppercase block mb-1 italic">Nesting Bond Standard</span>
                                            <span class="text-sm font-industrial font-black text-white tracking-widest">{{ gmdate("H:i:s", $timeUntilReady) }}</span>
                                        </div>
                                    @else
                                        <button wire:click="breedPair({{ $pair->id }})" 
                                                class="flex-1 py-4 bg-white hover:bg-[#b8860b] text-black hover:text-white font-industrial font-black text-[10px] rounded-2xl transition-all shadow-xl uppercase italic tracking-widest">
                                            Breed Birds (100💰)
                                        </button>
                                    @endif
                                    <button wire:click="disband({{ $pair->id }})" 
                                            class="py-4 px-8 bg-[#1a2a2a] hover:bg-red-800 text-slate-400 hover:text-white font-industrial font-black text-[10px] rounded-2xl transition-all border border-white/5 uppercase italic">
                                        Release
                                    </button>
                                @else
                                    <div class="flex-1 bg-black/40 p-5 rounded-3xl border border-[#b8860b]/20 flex items-center justify-center">
                                        <p class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest italic text-center">Parents occupied with incubation</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($pairs->isEmpty())
                        <div class="col-span-1 md:col-span-2 py-20 border-2 border-dashed border-[#b8860b]/10 rounded-[3rem] md:rounded-[4rem] text-center bg-black/10">
                            <p class="font-industrial font-black text-slate-700 text-base md:text-2xl uppercase italic tracking-[0.2em]">No active breeding pairs established</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

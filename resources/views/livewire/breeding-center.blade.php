<div class="space-y-12">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-yellow-500 text-black px-6 py-3 rounded-xl shadow-2xl font-black font-industrial">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-slate-950 p-6 md:p-10 rounded-[2rem] md:rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 md:p-8 opacity-5 text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter">Genetics</div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8 mb-8 md:mb-12 bg-black/40 p-6 md:p-8 rounded-[2rem] border border-yellow-500/20">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight mb-2">Facility Capacity</h2>
                    <p class="text-slate-500 text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] md:tracking-[0.3em]">Module link: Loft Level {{ Auth::user()->loft->level }}</p>
                </div>
                <div class="flex items-center gap-4 md:gap-6">
                    <div class="text-center">
                        <span class="text-3xl md:text-5xl font-industrial font-black text-yellow-500">{{ $pairs->count() }}</span>
                        <span class="block text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1 italic whitespace-nowrap">Active Chambers</span>
                    </div>
                    <div class="w-[1px] h-10 md:h-12 bg-slate-800"></div>
                    <div class="text-center text-slate-700">
                        <span class="text-3xl md:text-5xl font-industrial font-black italic">{{ Auth::user()->loft->level }}</span>
                        <span class="block text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1 italic whitespace-nowrap">Max Capacity</span>
                    </div>
                </div>
            </div>

            @if($pairs->count() < Auth::user()->loft->level)
                <div class="flex items-center gap-4 mb-6 md:mb-8 px-2">
                    <div class="w-8 md:w-12 h-1 bg-yellow-500 rounded-full"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Protocol: Stabilization</h3>
                    <div class="flex-1 h-[1px] bg-slate-800"></div>
                </div>

                <form wire:submit="createPair" class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-end bg-slate-900 p-6 md:p-8 rounded-[2rem] border border-slate-800 shadow-xl">
                    <div class="space-y-2">
                        <label class="block text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Sire Selection (♂)</label>
                        <select wire:model="maleId" class="w-full bg-black/50 border-2 border-slate-800 rounded-2xl p-3 md:p-4 text-white font-bold text-xs md:text-base focus:border-yellow-500 transition-all appearance-none cursor-pointer">
                            <option value="">SELECT MATURE SIRE</option>
                            @foreach($males as $p) <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }}]</option> @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Dam Selection (♀)</label>
                        <select wire:model="femaleId" class="w-full bg-black/50 border-2 border-slate-800 rounded-2xl p-3 md:p-4 text-white font-bold text-xs md:text-base focus:border-yellow-500 transition-all appearance-none cursor-pointer">
                            <option value="">SELECT MATURE DAM</option>
                            @foreach($females as $p) <option value="{{ $p->id }}">{{ strtoupper($p->name) }} [LV.{{ $p->level }}]</option> @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-black font-industrial font-black text-xs md:text-sm rounded-2xl transition-all shadow-xl shadow-yellow-500/10 uppercase italic tracking-widest">
                        Initiate Link
                    </button>
                </form>
            @else
                <div class="bg-red-950/20 p-6 md:p-8 rounded-[2rem] border-2 border-dashed border-red-500/30 text-center">
                    <p class="font-industrial font-black text-red-500 text-base md:text-lg uppercase italic tracking-widest">Max capacity reached. System upgrade required.</p>
                </div>
            @endif

            <div class="mt-12 md:mt-16">
                <div class="flex items-center gap-4 mb-6 md:mb-8 px-2">
                    <div class="w-8 md:w-12 h-1 bg-yellow-500 rounded-full"></div>
                    <h3 class="text-lg md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Active Chambers</h3>
                    <div class="flex-1 h-[1px] bg-slate-800"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    @foreach($pairs as $pair)
                        @php
                            $record = $breedingRecords->where('sire_id', $pair->male_id)->where('dam_id', $pair->female_id)->first();
                        @endphp
                        <div class="bg-slate-900 rounded-[2.5rem] border-2 border-slate-800 p-6 md:p-8 hover:border-yellow-500/20 transition-all duration-300 relative overflow-hidden shadow-2xl">
                            <div class="absolute top-0 left-0 w-full h-1 bg-yellow-500/10"></div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-6 gap-4">
                                <div class="w-full sm:w-auto">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2 h-2 rounded-full {{ $record ? 'bg-yellow-500 animate-pulse' : 'bg-green-500' }}"></span>
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest italic">{{ $record ? 'Incubating' : 'Standby' }}</span>
                                    </div>
                                    <h4 class="text-lg md:text-xl font-industrial font-black text-white italic tracking-tighter uppercase truncate max-w-[15rem]">
                                        {{ $pair->male->name }} <span class="text-yellow-500 text-xs mx-1">&</span> {{ $pair->female->name }}
                                    </h4>
                                </div>
                                @if($record)
                                    @php
                                        $hatchTime = $record->eggs_laid_at->addDay();
                                        $remaining = now()->diffInSeconds($hatchTime, false);
                                    @endphp
                                    <div class="text-left sm:text-right bg-black/40 sm:bg-transparent p-3 sm:p-0 rounded-xl border border-slate-800 sm:border-none w-full sm:w-auto" wire:key="timer-{{ $record->id }}">
                                        <span class="text-[7px] md:text-[8px] font-black text-yellow-500 block uppercase mb-1">Hatch sequence</span>
                                        <span class="text-lg md:text-xl font-industrial font-black text-white tracking-widest" wire:poll.1s>
                                            @if($remaining > 0)
                                                {{ gmdate("H:i:s", $remaining) }}
                                            @else
                                                READY
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col sm:flex-row gap-2">
                                @php
                                    $readyToBreedTime = $pair->created_at->addHours(6);
                                    $timeUntilReady = now()->diffInSeconds($readyToBreedTime, false);
                                @endphp

                                @if(!$record)
                                    @if($timeUntilReady > 0)
                                        <div class="w-full bg-black/40 p-3 rounded-xl border border-slate-800 text-center">
                                            <span class="text-[7px] md:text-[8px] font-black text-slate-500 uppercase block mb-1">Pairing Bond</span>
                                            <span class="text-xs font-industrial font-black text-white tracking-widest">{{ gmdate("H:i:s", $timeUntilReady) }}</span>
                                        </div>
                                    @else
                                        <button wire:click="breedPair({{ $pair->id }})" 
                                                class="flex-1 py-4 bg-white hover:bg-yellow-500 text-black font-industrial font-black text-[10px] rounded-2xl transition-all shadow-xl uppercase italic tracking-widest">
                                            Breed (100💰)
                                        </button>
                                    @endif
                                    <button wire:click="disband({{ $pair->id }})" 
                                            class="py-4 px-6 bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white font-industrial font-black text-[10px] rounded-2xl transition-all uppercase italic">
                                        End
                                    </button>
                                @else
                                    <div class="flex-1 bg-black/40 p-4 rounded-2xl border border-yellow-500/20 flex items-center justify-center">
                                        <p class="text-[8px] md:text-[9px] font-black text-slate-500 uppercase tracking-widest italic text-center">Unit busy with egg production</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if($pairs->isEmpty())
                        <div class="col-span-1 md:col-span-2 p-8 md:p-12 border-2 border-dashed border-slate-800 rounded-[2rem] md:rounded-[3rem] text-center">
                            <p class="font-industrial font-black text-slate-700 text-base md:text-xl uppercase italic tracking-widest">No active genetic links established</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-6 md:space-y-8 p-6 md:p-10 bg-slate-950 rounded-[2rem] md:rounded-[3rem] border-2 border-slate-800 shadow-2xl">
    <h2 class="text-xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-widest">Training Center</h2>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-xl shadow-2xl font-black font-industrial">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-8">
        <!-- Pigeon Selection -->
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-[10px] font-black text-yellow-500 uppercase tracking-[0.2em] italic">Select Pigeons</h3>
            <div class="max-h-[30vh] lg:max-h-[60vh] overflow-y-auto space-y-2 pr-2 custom-scrollbar bg-black/20 p-2 rounded-2xl border border-slate-800/50">
                @foreach($pigeons as $pigeon)
                    <label class="flex items-center gap-3 p-3 bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-800 transition border border-transparent hover:border-yellow-500/20">
                        <input type="checkbox" wire:model.live="selectedPigeonIds" value="{{ $pigeon->id }}" class="rounded bg-slate-800 border-slate-700 text-yellow-500 focus:ring-yellow-500">
                        <span class="text-white font-bold text-xs md:text-sm">{{ $pigeon->name }} <span class="text-yellow-500 text-[10px] ml-1">LV.{{ $pigeon->level }}</span></span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Training Actions -->
        <div class="lg:col-span-3 space-y-6 md:space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                <button wire:click="train('flight')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all text-xs md:text-sm">
                    Flight Training <span class="block text-[8px] md:text-[9px] text-slate-500 font-normal normal-case">Cost: 20 Energy/bird</span>
                </button>
                <button wire:click="train('distance')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all text-xs md:text-sm">
                    Distance Training <span class="block text-[8px] md:text-[9px] text-slate-500 font-normal normal-case">Cost: 20 Energy/bird</span>
                </button>
                <button wire:click="train('grooming')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all text-xs md:text-sm">
                    Grooming <span class="block text-[8px] md:text-[9px] text-slate-500 font-normal normal-case">Cost: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="train('physical_care')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all text-xs md:text-sm">
                    Physical Care <span class="block text-[8px] md:text-[9px] text-slate-500 font-normal normal-case">Cost: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="train('gene_therapy')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all text-xs md:text-sm">
                    Gene Therapy <span class="block text-[8px] md:text-[9px] text-slate-500 font-normal normal-case">Cost: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="restAll" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-yellow-500/50 text-yellow-500 font-black italic uppercase transition-all text-xs md:text-sm">
                    Restore Energy <span class="block text-[8px] md:text-[9px] text-yellow-500/70 font-normal normal-case">Total: {{ $restCost * count($selectedPigeonIds) }} 💰</span>
                </button>
            </div>
            
            <!-- Stats Display for Selected Pigeons -->
            <div class="grid grid-cols-1 gap-6 md:gap-8">
                @foreach($selectedPigeons as $pigeon)
                    <div class="group relative bg-slate-950 rounded-[2rem] border-2 border-slate-800 transition-all duration-500 overflow-hidden shadow-2xl">
                        <div class="bg-gradient-to-r from-slate-900 to-slate-950 p-4 md:p-6 border-b border-slate-800">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <span class="bg-yellow-500 text-black font-industrial font-black text-[10px] md:text-xs px-2 py-0.5 rounded italic">LV.{{ $pigeon->level }}</span>
                                    <span class="text-base md:text-xl font-industrial font-black text-white">{{ $pigeon->name }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-tighter">Vitality</span>
                                    <span class="block text-sm md:text-lg font-black text-white">{{ $pigeon->energy }}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 md:p-6">
                            @php
                                $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                                $required = $pigeon->level * 30;
                                $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                            @endphp
                            <div class="bg-slate-900/50 p-4 rounded-2xl border border-slate-800 mb-6">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-500">Upgrade Readiness</span>
                                        <span class="text-[8px] md:text-[9px] font-bold text-slate-600">{{ $totalStats }} / {{ $required }} cumulative stats</span>
                                    </div>
                                    @if($pigeon->level < Auth::user()->loft->level)
                                        <button wire:click="levelUp({{ $pigeon->id }})"
                                            @if($totalStats < $required) disabled @endif
                                            class="w-full sm:w-auto px-4 py-2 rounded-lg font-black font-industrial italic uppercase text-[9px] md:text-[10px] transition-all
                                                {{ $totalStats >= $required 
                                                    ? 'bg-yellow-500 text-black hover:bg-yellow-400 shadow-[0_0_15px_rgba(234,179,8,0.3)]' 
                                                    : 'bg-slate-800 text-slate-500 cursor-not-allowed' }}">
                                            Authorize Level Up
                                        </button>
                                    @else
                                        <span class="text-[8px] font-black text-red-500/50 uppercase italic px-2">Loft Capacity Reached</span>
                                    @endif
                                </div>
                                <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-500 transition-all duration-700 shadow-[0_0_10px_rgba(234,179,8,0.5)]" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                <div class="space-y-4">
                                    <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Combat Metrics</h4>
                                    @foreach(['speed' => 'RUN', 'endurance' => 'POW', 'navigation' => 'DIR', 'temperament' => 'MND', 'loyalty' => 'LOY', 'intelligence' => 'INT'] as $stat => $label)
                                        <div class="relative">
                                            <div class="flex justify-between items-end mb-1">
                                                <span class="text-[8px] md:text-[9px] font-black text-slate-400">{{ $label }}</span>
                                                <div class="flex items-center gap-2">
                                                    @if(isset($statGains[$pigeon->id][$stat]))
                                                        <span class="text-[9px] md:text-[10px] font-black text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                    @endif
                                                    <span class="text-[10px] md:text-xs font-black {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ $pigeon->$stat }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1 h-1 bg-slate-800 rounded-full overflow-hidden">
                                                <div class="h-full {{ isset($statGains[$pigeon->id][$stat]) ? 'bg-green-500' : 'bg-yellow-500' }} transition-all duration-1000" style="width: {{ min(100, ($pigeon->$stat / ($pigeon->level * 10)) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="space-y-3 bg-white/5 p-4 rounded-2xl border border-white/5 h-fit">
                                    <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center mb-2">Aesthetic Profile</h4>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                        @foreach(['eyes' => '👁️', 'beak' => '👃', 'legs' => '🦵', 'feather_quality' => '✨', 'pattern' => '🎨', 'color' => '🌈', 'purity' => '💎'] as $stat => $icon)
                                            <div class="flex justify-between items-center border-b border-white/5 pb-1">
                                                <span class="text-[7px] md:text-[8px] text-slate-500 uppercase font-black truncate">{{ str_replace('_', ' ', $stat) }}</span>
                                                <div class="flex items-center gap-1">
                                                    @if(isset($statGains[$pigeon->id][$stat]))
                                                        <span class="text-[8px] md:text-[9px] font-black text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                    @endif
                                                    <span class="text-[9px] {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }} font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

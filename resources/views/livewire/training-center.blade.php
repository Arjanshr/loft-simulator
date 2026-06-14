<div class="space-y-8 p-10 bg-slate-950 rounded-[3rem] border-2 border-slate-800 shadow-2xl">
    <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest">Training Center</h2>

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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Pigeon Selection -->
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-xs font-black text-yellow-500 uppercase tracking-[0.2em] italic">Select Pigeons</h3>
            <div class="max-h-[60vh] overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                @foreach($pigeons as $pigeon)
                    <label class="flex items-center gap-3 p-3 bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-800 transition">
                        <input type="checkbox" wire:model.live="selectedPigeonIds" value="{{ $pigeon->id }}" class="rounded bg-slate-800 border-slate-700 text-yellow-500 focus:ring-yellow-500">
                        <span class="text-white font-bold">{{ $pigeon->name }} (LV.{{ $pigeon->level }})</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Training Actions -->
        <div class="lg:col-span-3 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <button wire:click="train('flight')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all">
                    Flight Training <span class="block text-[9px] text-slate-500 font-normal normal-case">Cost: 20 Energy/bird</span>
                </button>
                <button wire:click="train('distance')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all">
                    Distance Training <span class="block text-[9px] text-slate-500 font-normal normal-case">Cost: 20 Energy/bird</span>
                </button>
                <button wire:click="train('grooming')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all">
                    Grooming <span class="block text-[9px] text-slate-500 font-normal normal-case">Total: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="train('physical_care')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all">
                    Physical Care <span class="block text-[9px] text-slate-500 font-normal normal-case">Total: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="train('gene_therapy')" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-slate-700 text-white font-black italic uppercase transition-all">
                    Gene Therapy <span class="block text-[9px] text-slate-500 font-normal normal-case">Total: {{ number_format($totalCost) }} 💰</span>
                </button>
                <button wire:click="restAll" class="p-4 bg-slate-950 hover:bg-slate-800 rounded-xl border border-yellow-500/50 text-yellow-500 font-black italic uppercase transition-all">
                    Restore Energy <span class="block text-[9px] text-yellow-500/70 font-normal normal-case">Cost: {{ $restCost * count($selectedPigeonIds) }} 💰</span>
                </button>
            </div>
            
            <!-- Stats Display for Selected Pigeons -->
            <div class="space-y-4">
                @foreach($selectedPigeons as $pigeon)
                    <div class="group relative bg-slate-950 rounded-[2rem] border-2 border-slate-800 transition-all duration-500 overflow-hidden shadow-2xl">
                        <div class="bg-gradient-to-r from-slate-900 to-slate-950 p-6 border-b border-slate-800">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="bg-yellow-500 text-black font-industrial font-black text-xs px-2 py-0.5 rounded italic">LV.{{ $pigeon->level }}</span>
                                        <span class="text-xl font-industrial font-black text-white">{{ $pigeon->name }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Vitality</span>
                                    <span class="block text-lg font-black text-white">{{ $pigeon->energy }}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            @php
                                $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                                $required = $pigeon->level * 30;
                                $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                            @endphp
                            <div class="flex items-center gap-4 mb-6 bg-slate-900/50 p-4 rounded-2xl border border-slate-800">
                                <div class="flex-1">
                                    <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                                        <span>EXP Progress</span>
                                        <span>{{ $totalStats }} / {{ $required }}</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-yellow-500 transition-all duration-700" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Core Stats</h4>
                                    @foreach(['speed' => 'RUN', 'endurance' => 'POW', 'navigation' => 'DIR', 'temperament' => 'MND', 'loyalty' => 'LOY', 'intelligence' => 'INT'] as $stat => $label)
                                        <div class="relative">
                                            <div class="flex justify-between items-end mb-1">
                                                <span class="text-[9px] font-black text-slate-400">{{ $label }}</span>
                                                <div class="flex items-center gap-2">
                                                    @if(isset($statGains[$pigeon->id][$stat]))
                                                        <span class="text-[10px] font-black text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                    @endif
                                                    <span class="text-xs font-black {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ $pigeon->$stat }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1 h-1 bg-slate-800 rounded-full overflow-hidden">
                                                <div class="h-full {{ isset($statGains[$pigeon->id][$stat]) ? 'bg-green-500' : 'bg-yellow-500' }} transition-all duration-1000" style="width: {{ min(100, ($pigeon->$stat / ($pigeon->level * 10)) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="space-y-3 bg-white/5 p-4 rounded-2xl border border-white/5">
                                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Beauty Stats</h4>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                        @foreach(['eyes' => '👁️', 'beak' => '👃', 'legs' => '🦵', 'feather_quality' => '✨', 'pattern' => '🎨', 'color' => '🌈', 'purity' => '💎'] as $stat => $icon)
                                            <div class="flex justify-between">
                                                <span class="text-[8px] text-slate-500 uppercase font-black truncate">{{ str_replace('_', ' ', $stat) }}</span>
                                                <div class="flex items-center gap-1">
                                                    @if(isset($statGains[$pigeon->id][$stat]))
                                                        <span class="text-[9px] font-black text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }}</span>
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

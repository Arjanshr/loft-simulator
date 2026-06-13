<div class="text-slate-200" x-data="{}" x-on:pigeon-leveled-up.window="alert('Congratulations! ' + $event.detail.name + ' leveled up!')">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @foreach($pigeons as $pigeon)
            <div class="border rounded-lg p-4 bg-slate-800 border-slate-700">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <input type="text" wire:model="newName.{{ $pigeon->id }}" placeholder="{{ $pigeon->name }}" class="bg-slate-700 border-none rounded p-1 text-sm font-bold text-white w-32 focus:ring-2 focus:ring-yellow-500">
                            <button wire:click="updateName({{ $pigeon->id }})" class="text-[10px] bg-yellow-500 text-black px-2 py-1 rounded font-bold hover:bg-yellow-400 transition">Rename</button>
                        </div>
                        <span class="text-xs text-yellow-500 font-bold ml-1">Lv.{{ $pigeon->level }}</span>
                        <div class="flex gap-2 mt-1">
                            <span class="text-[10px] bg-slate-700 px-2 py-0.5 rounded uppercase text-slate-300">{{ $pigeon->type }}</span>
                            <span class="text-[10px] bg-indigo-500 px-2 py-0.5 rounded uppercase text-white">{{ ucfirst($pigeon->gender) }}</span>
                            <span class="text-[10px] bg-yellow-600/20 text-yellow-500 px-2 py-0.5 rounded uppercase">{{ $pigeon->rarity }}</span>
                            @php
                                $ageDays = $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0;
                                $status = 'Adult';
                                if (!$pigeon->hatch_at || $pigeon->hatch_at->isFuture()) $status = 'Egg';
                                elseif ($pigeon->hatch_at->addDay()->isFuture()) $status = 'Hatchling';
                                elseif ($pigeon->birth_at->addDays(4)->isFuture()) $status = 'Juvenile';
                            @endphp
                            <span class="text-[10px] bg-slate-700 px-2 py-0.5 rounded uppercase text-slate-300">{{ $status }} ({{ $ageDays }} days)</span>
                        </div>
                        
                        @php
                            $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                            $required = $pigeon->level * 30;
                            $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                        @endphp

                        <div class="mt-4">
                            <div class="flex justify-between text-[10px] text-slate-400 mb-1">
                                <span class="font-bold text-slate-200">Lv. {{ $pigeon->level }} → Lv. {{ $pigeon->level + 1 }}</span>
                                <span>{{ $totalStats }} / {{ $required }} Stats</span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        @if($totalStats >= $required && $pigeon->level < 100)
                            <button wire:click="levelUp({{ $pigeon->id }})" class="mt-2 w-full text-[10px] bg-yellow-500 text-black px-2 py-1 rounded font-bold hover:bg-yellow-400 transition">Level Up!</button>
                        @endif
                    </div>
                    
                    <div class="text-right">
                        <div class="text-sm font-medium">⚡ Energy: {{ $pigeon->energy }}%</div>
                        <div class="w-24 bg-slate-700 rounded-full h-1.5 mt-1">
                            <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $pigeon->energy }}%"></div>
                        </div>
                        @if($pigeon->energy < 100)
                            <button wire:click="rest({{ $pigeon->id }})" class="mt-2 w-full text-[9px] bg-slate-700 text-slate-300 px-2 py-1 rounded hover:bg-slate-600 transition font-bold">
                                Rest (50 💰)
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Stats & Beauty -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                    <!-- Trainable Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(['speed' => '🏃', 'endurance' => '🔋', 'navigation' => '🧭', 'temperament' => '🧘'] as $stat => $icon)
                            <div class="bg-slate-900 p-2 rounded border border-slate-700">
                                <div class="flex justify-between text-[10px] mb-1 text-slate-400">
                                    <span class="truncate">{{ $icon }} {{ ucfirst($stat) }}</span>
                                    <span class="font-bold text-white">{{ $pigeon->$stat }}</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-1 mb-2">
                                    <div class="bg-yellow-500 h-1 rounded-full transition-all duration-500" style="width: {{ ($pigeon->$stat / ($pigeon->level * 10)) * 100 }}%"></div>
                                </div>
                                <button 
                                    wire:click="train({{ $pigeon->id }}, '{{ $stat }}')"
                                    wire:loading.attr="disabled"
                                    class="w-full text-[9px] bg-slate-800 hover:bg-yellow-600 hover:text-black text-slate-300 py-0.5 rounded transition font-bold"
                                    @if($pigeon->energy < 20 || $pigeon->status !== 'idle') disabled @endif
                                >
                                    Train
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Beauty Attributes -->
                    <div class="bg-slate-950 p-4 rounded-lg border border-slate-700">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-bold text-sm text-white">Aesthetics <span class="text-yellow-500">(Beauty: {{ number_format($pigeon->beauty, 1) }})</span></h4>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[10px]">
                            @foreach(['eyes' => '👁️', 'beak' => '👃', 'legs' => '🦵', 'feather_quality' => '✨', 'pattern' => '🎨', 'color' => '🌈', 'purity' => '💎'] as $stat => $icon)
                                <div class="flex flex-col gap-1 bg-slate-900 px-2 py-1 rounded border border-slate-700 text-slate-300">
                                    <div class="flex justify-between">
                                        <span>{{ $icon }} {{ ucfirst(str_replace('_', ' ', $stat)) }}</span>
                                        <span class="font-bold text-white">{{ number_format($pigeon->$stat, 1) }}</span>
                                    </div>
                                    @if(in_array($stat, ['feather_quality', 'pattern', 'color']))
                                        <button 
                                            wire:click="improveAesthetic({{ $pigeon->id }}, '{{ $stat }}')"
                                            class="mt-1 w-full text-[8px] bg-yellow-600/20 text-yellow-500 hover:bg-yellow-600 hover:text-black py-0.5 rounded transition font-bold"
                                        >
                                            Improve ({{ number_format(50 * pow(1.15, $pigeon->$stat)) }} 💰)
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

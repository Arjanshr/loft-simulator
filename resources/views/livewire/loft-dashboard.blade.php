<div class="space-y-12">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-yellow-500 text-black px-6 py-3 rounded-xl shadow-2xl font-black font-industrial">
            {{ session('message') }}
        </div>
    @endif

    @if($showCreateForm)
        <div class="max-w-md mx-auto glow-card p-10 rounded-[3rem] border-t-8 border-t-yellow-500 text-center">
            <h2 class="text-4xl font-industrial font-black text-white mb-4 uppercase italic">Establish Loft</h2>
            <p class="text-slate-500 mb-8 font-bold uppercase tracking-widest text-xs">Initialization sequence required to begin operation.</p>
            <form wire:submit.prevent="createLoft" class="space-y-6">
                <input wire:model="loftName" class="w-full bg-black/40 border-2 border-slate-800 rounded-2xl p-4 text-white text-center font-black focus:border-yellow-500 transition-all placeholder-slate-700" type="text" placeholder="LOFT IDENTIFIER">
                @error('loftName') <span class="text-red-500 text-xs font-black block uppercase tracking-tighter">{{ $message }}</span> @enderror
                <button type="submit" class="w-full bg-yellow-500 text-black font-industrial font-black py-5 rounded-2xl hover:bg-yellow-400 transition shadow-xl shadow-yellow-500/20 uppercase italic tracking-widest text-xl">Confirm Registry</button>
            </form>
        </div>
    @elseif($loft)
        <!-- Dashboard Hero -->
        <div class="relative overflow-hidden bg-slate-950 rounded-[3rem] border-2 border-slate-800 p-10 shadow-2xl">
            <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none">
                {{ strtoupper($loft->name) }}
            </div>
            
            <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-12">
                <div class="text-center lg:text-left">
                    <span class="text-yellow-500 font-industrial font-black text-sm tracking-[0.3em] uppercase mb-2 block">Intelligence Hub</span>
                    <h1 class="text-5xl lg:text-7xl font-industrial font-black text-white italic uppercase tracking-tighter leading-none mb-4">{{ $loft->name }}</h1>
                    
                    <div class="flex items-center gap-4 justify-center lg:justify-start">
                        <div class="px-4 py-1 bg-yellow-500 text-black font-industrial font-black text-sm italic rounded-lg">LEVEL {{ $loft->level }}</div>
                        <div class="h-1 w-32 bg-slate-800 rounded-full overflow-hidden">
                             @php
                                $nextLevel = $loft->level + 1;
                                $xpRequired = $nextLevel * $nextLevel * 100;
                                $progress = min(100, ($loft->xp / ($xpRequired ?: 1)) * 100);
                            @endphp
                            <div class="h-full bg-yellow-500 shadow-[0_0_10px_#facc15]" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $loft->xp }} / {{ $xpRequired }} OPERATIONAL XP</span>
                    </div>
                </div>

                <div class="flex gap-12">
                    <div class="text-center">
                        <div class="text-5xl font-industrial font-black text-white">{{ number_format($loft->coins) }}</div>
                        <div class="text-[10px] font-black text-yellow-500 uppercase tracking-[0.3em] mt-2 italic">Resources (💰)</div>
                    </div>
                    
                    @if($loft->xp >= $xpRequired)
                        <button wire:click="upgrade" 
                                class="bg-white text-black font-industrial font-black px-8 py-4 rounded-2xl hover:bg-yellow-500 transition shadow-2xl active:scale-95 uppercase italic tracking-widest text-sm self-center">
                            Upgrade System
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Operational Summary -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-slate-950 p-8 rounded-[2rem] border-2 border-slate-800 shadow-xl">
                    <h2 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-6">Inventory Analysis</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-black/40 p-4 rounded-2xl border border-slate-800 text-center">
                            <span class="block text-3xl font-industrial font-black text-white">{{ $loft->pigeons->count() }}</span>
                            <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Total Units</span>
                        </div>
                        <div class="bg-black/40 p-4 rounded-2xl border border-slate-800 text-center">
                            <span class="block text-3xl font-industrial font-black text-yellow-500">{{ $loft->pigeons->where('type', 'racer')->count() }}</span>
                            <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Racers</span>
                        </div>
                        <div class="bg-black/40 p-4 rounded-2xl border border-slate-800 text-center">
                            <span class="block text-3xl font-industrial font-black text-indigo-400">{{ $loft->pigeons->where('type', 'fancy')->count() }}</span>
                            <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Fancy</span>
                        </div>
                        <div class="bg-black/40 p-4 rounded-2xl border border-slate-800 text-center">
                            <span class="block text-3xl font-industrial font-black text-green-400">{{ $loft->pigeons->where('type', 'highflyer')->count() }}</span>
                            <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Highflyers</span>
                        </div>
                    </div>
                </div>

                <!-- Strategic Assets (Top 3) -->
                <div class="bg-slate-950 p-8 rounded-[2rem] border-2 border-slate-800 shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest">Elite Assets</h2>
                        <a href="{{ route('pigeons.index') }}" class="text-[10px] font-black text-yellow-500 uppercase tracking-widest hover:underline">Manage All Units →</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($loft->pigeons->sortByDesc('total_score')->take(3) as $p)
                            <div class="flex justify-between items-center bg-black/40 p-4 rounded-2xl border border-slate-800">
                                <div class="flex items-center gap-4">
                                    <span class="font-industrial font-black text-yellow-500 italic text-sm">LV.{{ $p->level }}</span>
                                    <span class="font-bold text-white uppercase text-sm tracking-wider">{{ $p->name }}</span>
                                </div>
                                <span class="font-industrial font-black text-yellow-500">{{ number_format($p->total_score, 1) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Intelligence Sidebar -->
            <div class="space-y-8">
                <!-- Status Module -->
                <div class="bg-slate-950 p-8 rounded-[2rem] border-2 border-slate-800 shadow-xl">
                    <h2 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-6">Real-time Feed</h2>
                    <div class="space-y-4">
                        @php
                            $breedingCount = $loft->breedingRecords->count();
                        @endphp
                        @if($breedingCount > 0)
                            <div class="bg-yellow-500/10 p-4 rounded-2xl border border-yellow-500/20">
                                <p class="text-yellow-500 font-black text-xs uppercase tracking-widest animate-pulse">🧬 Genetic Link Active</p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold">{{ $breedingCount }} pairs currently in incubation protocol.</p>
                            </div>
                        @endif
                        
                        <div class="bg-black/40 p-4 rounded-2xl border border-slate-800">
                            <p class="text-white font-black text-xs uppercase tracking-widest">🏆 Field Status</p>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold">{{ $loft->pigeons->where('status', 'racing')->count() }} units currently deployed to tournaments.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Access -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('tournaments') }}" class="bg-slate-900 hover:bg-yellow-500 group p-4 rounded-[1.5rem] border-2 border-slate-800 transition-all text-center">
                        <span class="block text-2xl mb-1">🏁</span>
                        <span class="text-[8px] font-black text-slate-500 group-hover:text-black uppercase tracking-widest">Combat</span>
                    </a>
                    <a href="{{ route('breeding.center') }}" class="bg-slate-900 hover:bg-yellow-500 group p-4 rounded-[1.5rem] border-2 border-slate-800 transition-all text-center">
                        <span class="block text-2xl mb-1">🧬</span>
                        <span class="text-[8px] font-black text-slate-500 group-hover:text-black uppercase tracking-widest">Genetics</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

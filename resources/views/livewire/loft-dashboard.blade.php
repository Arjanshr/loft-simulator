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
                    <span class="text-yellow-500 font-industrial font-black text-sm tracking-[0.3em] uppercase mb-2 block">Command Center</span>
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

        <!-- Pigeons Section -->
        <section>
            <div class="flex items-center gap-4 mb-8 px-2">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Active Units</h2>
                <div class="flex-1 h-[1px] bg-slate-800"></div>
            </div>
            
            <livewire:pigeon-manager />
        </section>
    @endif
</div>

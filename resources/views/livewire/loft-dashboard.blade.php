<div class="space-y-12 font-sans text-slate-300">
    @if($showCreateForm)
        <div class="max-w-md mx-auto bg-[#050a0a] p-10 rounded-[3rem] border-t-8 border-t-[#b8860b] text-center border-2 border-[#b8860b]/20 shadow-2xl">
            <h2 class="text-4xl font-industrial font-black text-white mb-4 uppercase italic">Loft Registration</h2>
            <p class="text-slate-500 mb-8 font-bold uppercase tracking-widest text-xs italic">Registry sequence required to begin management.</p>
            <form wire:submit.prevent="createLoft" class="space-y-6">
                <input wire:model="loftName" class="w-full bg-black/40 border-2 border-slate-800 rounded-2xl p-5 text-white text-center font-black focus:border-[#b8860b] transition-all placeholder-slate-700 font-industrial italic" type="text" placeholder="LOFT IDENTIFIER">
                @error('loftName') <span class="text-red-500 text-xs font-black block uppercase tracking-tighter">{{ $message }}</span> @enderror
                <button type="submit" class="w-full bg-[#b8860b] text-white font-industrial font-black py-5 rounded-2xl hover:bg-white hover:text-black transition shadow-xl uppercase italic tracking-widest text-xl">Register Loft</button>
            </form>
        </div>
    @elseif($loft)
        <!-- Dashboard Hero -->
        <div class="relative overflow-hidden bg-[#050a0a] rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/10 p-6 md:p-12 shadow-2xl">
            <div class="absolute top-0 right-0 p-4 md:p-10 opacity-5 text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none text-[#b8860b] uppercase">
                {{ $loft->name }}
            </div>
            
            <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-16">
                <div class="text-center lg:text-left">
                    <span class="text-[#b8860b] font-industrial font-black text-[10px] md:text-sm tracking-[0.4em] uppercase mb-3 block italic">Loft Ledger</span>
                    <h1 class="text-4xl md:text-6xl lg:text-8xl font-industrial font-black text-white italic uppercase tracking-tighter leading-tight md:leading-none mb-6 drop-shadow-2xl">{{ $loft->name }}</h1>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                        <div class="px-6 py-2 bg-[#b8860b] text-white font-industrial font-black text-xs md:text-base italic rounded-xl shadow-lg">LEVEL {{ $loft->level }}</div>
                        <div class="flex items-center gap-4 bg-black/30 px-5 py-2 rounded-xl border border-white/5">
                            <div class="h-1.5 w-24 md:w-40 bg-slate-900 rounded-full overflow-hidden">
                                @php
                                    $nextLevel = $loft->level + 1;
                                    $xpRequired = $nextLevel * $nextLevel * 100;
                                    $progress = min(100, ($loft->xp / ($xpRequired ?: 1)) * 100);
                                @endphp
                                <div class="h-full bg-[#b8860b] shadow-[0_0_15px_#b8860b]" style="width: {{ $progress }}%"></div>
                            </div>
                            <span class="text-[9px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest italic whitespace-nowrap">{{ number_format($loft->xp) }} / {{ number_format($xpRequired) }} XP</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-8 md:gap-12 w-full lg:w-auto">
                    <div class="text-center bg-black/40 p-6 md:p-8 rounded-3xl border border-[#b8860b]/10 min-w-[180px] shadow-inner">
                        <div class="text-4xl md:text-6xl font-industrial font-black text-white italic">{{ number_format($loft->coins) }}</div>
                        <div class="text-[9px] md:text-[11px] font-black text-[#b8860b] uppercase tracking-[0.3em] mt-3 italic">Loft Funds (💰)</div>
                    </div>
                    
                    @if($loft->xp >= $xpRequired)
                        <button wire:click="upgrade" 
                                class="w-full sm:w-auto bg-white text-black font-industrial font-black px-10 py-5 rounded-[2rem] hover:bg-[#b8860b] hover:text-white transition shadow-2xl active:scale-95 uppercase italic tracking-widest text-sm md:text-base self-center">
                            Upgrade Loft
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <livewire:stray-manager />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
            <!-- Operational Summary -->
            <div class="lg:col-span-2 space-y-8 md:space-y-12">
                <div class="bg-[#050a0a] p-6 md:p-10 rounded-[3rem] border-2 border-[#b8860b]/10 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#b8860b]/20 to-transparent"></div>
                    <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-[#b8860b] rounded-full"></span> Stock Overview
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group hover:border-[#b8860b]/30 transition-all">
                            <span class="block text-2xl md:text-4xl font-industrial font-black text-white mb-1 italic">{{ $loft->pigeons->count() }}</span>
                            <span class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Total Birds</span>
                        </div>
                        <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group hover:border-[#b8860b]/30 transition-all">
                            <span class="block text-2xl md:text-4xl font-industrial font-black text-[#b8860b] mb-1 italic">{{ $loft->pigeons->where('type', 'racer')->count() }}</span>
                            <span class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Racers</span>
                        </div>
                        <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group hover:border-[#b8860b]/30 transition-all">
                            <span class="block text-2xl md:text-4xl font-industrial font-black text-indigo-400 mb-1 italic">{{ $loft->pigeons->where('type', 'fancy')->count() }}</span>
                            <span class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Fancy</span>
                        </div>
                        <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group hover:border-[#b8860b]/30 transition-all">
                            <span class="block text-2xl md:text-4xl font-industrial font-black text-green-500 mb-1 italic">{{ $loft->pigeons->where('type', 'highflyer')->count() }}</span>
                            <span class="text-[8px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Highflyers</span>
                        </div>
                    </div>
                </div>

                <!-- Strategic Assets (Top 3) -->
                <div class="bg-[#050a0a] p-6 md:p-10 rounded-[3rem] border-2 border-[#b8860b]/10 shadow-xl">
                    <div class="flex justify-between items-center mb-8 border-b border-white/5 pb-4">
                        <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest">Champion Stock</h2>
                        <a href="{{ route('pigeons.index') }}" class="text-[9px] md:text-[11px] font-black text-[#b8860b] uppercase tracking-[0.2em] hover:text-white transition-colors italic">Manage All →</a>
                    </div>
                    <div class="space-y-4 md:space-y-6">
                        @foreach($loft->pigeons->sortByDesc('total_score')->take(3) as $p)
                            <div class="flex justify-between items-center bg-black/40 p-5 rounded-2xl border border-white/5 hover:border-[#b8860b]/20 transition-all group">
                                <div class="flex items-center gap-4 md:gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-[#b8860b]/10 flex items-center justify-center font-industrial font-black text-[#b8860b] text-xs italic border border-[#b8860b]/20">
                                        LV.{{ $p->level }}
                                    </div>
                                    <span class="font-bold text-white uppercase text-sm md:text-lg tracking-widest truncate max-w-[150px] md:max-w-none italic">{{ $p->name }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic mr-2">Score</span>
                                    <span class="font-industrial font-black text-[#b8860b] text-sm md:text-xl italic">{{ number_format($p->total_score, 1) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Loft Ledger Sidebar -->
            <div class="space-y-8 md:space-y-12">
                <!-- Status Module -->
                <div class="bg-[#050a0a] p-6 md:p-10 rounded-[3rem] border-2 border-[#b8860b]/10 shadow-xl">
                    <h2 class="text-lg md:text-xl font-industrial font-black text-white uppercase italic tracking-widest mb-8 border-b border-white/5 pb-4">Loft Activity</h2>
                    <div class="space-y-6">
                        @php
                            $breedingCount = $loft->breedingRecords->count();
                        @endphp
                        @if($breedingCount > 0)
                            <div class="bg-[#b8860b]/5 p-5 rounded-2xl border border-[#b8860b]/10">
                                <p class="text-[#b8860b] font-black text-[11px] md:text-xs uppercase tracking-[0.2em] animate-pulse flex items-center gap-2">
                                    <span class="w-2 h-2 bg-[#b8860b] rounded-full"></span> Nesting Active
                                </p>
                                <p class="text-[9px] md:text-[11px] text-slate-400 mt-2 uppercase font-bold italic">{{ $breedingCount }} pairs currently incubating.</p>
                            </div>
                        @endif
                        
                        <div class="bg-black/30 p-5 rounded-2xl border border-white/5">
                            <p class="text-white font-black text-[11px] md:text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span> Field Status
                            </p>
                            <p class="text-[9px] md:text-[11px] text-slate-400 mt-2 uppercase font-bold italic">{{ $loft->pigeons->where('status', 'racing')->count() }} birds in competition.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Access -->
                <div class="grid grid-cols-2 gap-6">
                    <a href="{{ route('tournaments') }}" class="bg-[#0a1414] hover:bg-[#b8860b] group p-6 rounded-[2rem] border-2 border-[#b8860b]/10 transition-all text-center shadow-xl">
                        <span class="block text-3xl mb-3 group-hover:scale-110 transition-transform">🏁</span>
                        <span class="text-[9px] font-black text-slate-500 group-hover:text-white uppercase tracking-[0.3em] italic">Racing</span>
                    </a>
                    <a href="{{ route('breeding.center') }}" class="bg-[#0a1414] hover:bg-[#b8860b] group p-6 rounded-[2rem] border-2 border-[#b8860b]/10 transition-all text-center shadow-xl">
                        <span class="block text-3xl mb-3 group-hover:scale-110 transition-transform">🥚</span>
                        <span class="text-[9px] font-black text-slate-500 group-hover:text-white uppercase tracking-[0.3em] italic">Breeding</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

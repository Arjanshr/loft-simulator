<div class="space-y-12 font-sans text-slate-300">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-[#b8860b] text-white px-6 py-4 rounded-xl shadow-2xl font-black font-industrial italic animate-bounce border-2 border-white/20">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-[#050a0a] p-6 md:p-10 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 md:p-10 opacity-5 text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">Headquarters</div>

        <div class="relative z-10">
            <div class="flex items-center gap-6 mb-10 md:mb-16">
                <div class="w-12 h-1 bg-[#b8860b] rounded-full shadow-[0_0_15px_rgba(184,134,11,0.3)]"></div>
                <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Administrative Panel</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16">
                <!-- Section: Game Balance -->
                <div class="bg-black/30 p-8 md:p-10 rounded-[3rem] border-2 border-[#b8860b]/10 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#b8860b]/20 to-transparent"></div>
                    <h3 class="text-[10px] font-black text-[#b8860b] uppercase tracking-[0.4em] mb-10 italic border-b border-white/5 pb-4">Loft Parameters</h3>
                    
                    <form wire:submit="updateSettings" class="space-y-6">
                        @foreach($settings as $key => $value)
                            <div class="bg-[#0a1414] p-5 rounded-2xl border border-white/5 group-hover:border-[#b8860b]/20 transition-all">
                                <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1 italic">{{ str_replace('_', ' ', $key) }}</label>
                                <input wire:model="settings.{{ $key }}" type="number" 
                                       class="w-full bg-black/40 border-none rounded-xl p-4 text-white font-bold font-industrial focus:ring-2 focus:ring-[#b8860b] transition-all shadow-inner">
                            </div>
                        @endforeach
                        
                        <button type="submit" 
                                class="w-full py-5 bg-[#b8860b] hover:bg-white hover:text-[#b8860b] text-white font-industrial font-black text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-widest mt-4">
                            Synchronize Settings
                        </button>
                    </form>
                </div>

                <!-- Section: Temporal Controls -->
                <div class="bg-black/30 p-8 md:p-10 rounded-[3rem] border-2 border-[#b8860b]/10 shadow-xl flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#b8860b]/20 to-transparent"></div>
                    <div>
                        <h3 class="text-[10px] font-black text-[#b8860b] uppercase tracking-[0.4em] mb-10 italic border-b border-white/5 pb-4">Manual Adjustments</h3>
                        
                        <div class="bg-[#0a1414] p-10 rounded-[2.5rem] border border-white/5 text-center space-y-8 shadow-inner group-hover:border-[#b8860b]/20 transition-all">
                            <div class="w-20 h-20 bg-[#b8860b]/5 rounded-full flex items-center justify-center mx-auto border-2 border-[#b8860b]/20 shadow-2xl">
                                <svg class="w-10 h-10 text-[#b8860b] animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-industrial font-black text-white text-2xl uppercase italic tracking-widest leading-tight">Registry Tick</p>
                                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-3 leading-relaxed italic mx-auto max-w-[200px]">Instantly trigger maturation, energy recovery, and market cycles.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10">
                        <button wire:click="runMaturation" 
                                class="w-full py-4 bg-white hover:bg-[#b8860b] hover:text-white text-black font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest">
                            Hatch & Mature
                        </button>
                        <button wire:click="runMarketTick" 
                                class="w-full py-4 bg-[#b8860b] hover:bg-white hover:text-[#b8860b] text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest">
                            Update Market
                        </button>
                        <button wire:click="runPassiveIncome" 
                                class="w-full py-4 bg-[#163333] hover:bg-green-600 text-green-400 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-1 md:col-span-2 border border-green-500/20">
                            Distribute Funds
                        </button>
                        <button wire:click="runEnergyRecovery" 
                                class="w-full py-4 bg-[#1a2a2a] hover:bg-blue-600 text-blue-400 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-1 md:col-span-2 border border-blue-500/20">
                            Restore Bird Energy
                        </button>
                        <button wire:click="runProcessLostBirds" 
                                class="w-full py-4 bg-[#2a1a2a] hover:bg-purple-600 text-purple-400 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-1 md:col-span-2 border border-purple-500/20">
                            Process Stray Birds
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }
    </style>
</div>

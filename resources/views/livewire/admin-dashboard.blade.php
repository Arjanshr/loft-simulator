<div class="space-y-12 font-sans text-slate-300">
    <!-- Notifications -->
    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
                 class="bg-aviary-blue text-white px-6 py-3 rounded-xl shadow-2xl font-industrial italic border-2 border-white/20 animate-bounce">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden galvanized-border">
        <div class="absolute top-0 right-0 p-4 md:p-10 opacity-[0.03] text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Control</div>

        <div class="relative z-10">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16 border-b border-aviary-brass/10 pb-10">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-1.5 bg-aviary-brass rounded-full shadow-[0_0_15px_#b8860b]"></div>
                    <div>
                        <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">Policy Desk</h2>
                        <p class="text-aviary-feather/40 text-[10px] md:text-xs font-black uppercase tracking-[0.4em] italic">Administrative Headquarters • Protocol Override</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-16">
                <!-- Section: Game Parameters -->
                <div class="bg-aviary-oak/40 p-8 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-xl relative overflow-hidden group galvanized-border">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-aviary-brass/20 to-transparent"></div>
                    <h3 class="text-[11px] font-black text-aviary-brass uppercase tracking-[0.4em] mb-10 italic border-b border-aviary-brass/10 pb-4">Loft Registry Parameters</h3>
                    
                    <form wire:submit="updateSettings" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($settings as $key => $value)
                                <div class="bg-black/30 p-5 rounded-2xl border border-aviary-brass/5 group-hover:border-aviary-brass/20 transition-all shadow-inner">
                                    <label class="block text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest mb-3 ml-1 italic">{{ str_replace('_', ' ', $key) }}</label>
                                    <input wire:model="settings.{{ $key }}" type="number" 
                                           class="w-full bg-aviary-oak/60 border-2 border-aviary-brass/10 rounded-xl p-4 text-white font-mono text-sm focus:border-aviary-blue focus:ring-0 transition-all shadow-inner italic">
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="submit" 
                                class="w-full py-5 bg-aviary-brass hover:bg-aviary-blue text-white font-industrial font-black text-sm rounded-2xl transition-all shadow-xl uppercase italic tracking-widest mt-6 border border-white/10 group">
                            <span class="group-hover:scale-105 transition-transform block">Synchronize Protocols</span>
                        </button>
                    </form>
                </div>

                <!-- Section: Temporal Adjustments -->
                <div class="bg-aviary-oak/40 p-8 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-xl flex flex-col justify-between relative overflow-hidden group galvanized-border">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-aviary-brass/20 to-transparent"></div>
                    <div>
                        <h3 class="text-[11px] font-black text-aviary-brass uppercase tracking-[0.4em] mb-10 italic border-b border-aviary-brass/10 pb-4">Chronos Adjustments</h3>
                        
                        <div class="bg-black/40 p-10 rounded-[2.5rem] border border-aviary-brass/10 text-center space-y-8 shadow-inner group-hover:border-aviary-brass/20 transition-all relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-aviary-brass/5 to-transparent pointer-events-none rounded-[2.5rem]"></div>
                            <div class="w-24 h-24 bg-aviary-oak rounded-full flex items-center justify-center mx-auto border-2 border-aviary-brass/20 shadow-2xl relative z-10">
                                <svg class="w-12 h-12 text-aviary-brass animate-spin-slow drop-shadow-[0_0_8px_rgba(184,134,11,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="relative z-10">
                                <p class="font-industrial font-black text-white text-3xl uppercase italic tracking-widest leading-tight">Registry Tick</p>
                                <p class="text-aviary-feather/40 text-[10px] font-bold uppercase tracking-widest mt-4 leading-relaxed italic mx-auto max-w-[240px]">Manually trigger maturation sequence, fund distribution, and market cycles.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-12 relative z-10">
                        <button wire:click="runMaturation" 
                                class="w-full py-4 bg-white hover:bg-aviary-brass hover:text-white text-black font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest border border-black/5">
                            Hatch & Mature
                        </button>
                        <button wire:click="runMarketTick" 
                                class="w-full py-4 bg-aviary-brass hover:bg-aviary-blue text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest border border-white/10">
                            Update Market
                        </button>
                        <button wire:click="runPassiveIncome" 
                                class="w-full py-4 bg-aviary-blue/10 hover:bg-aviary-blue text-aviary-blue hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-full border border-aviary-blue/20">
                            Distribute Reserve Funds
                        </button>
                        <button wire:click="runEnergyRecovery" 
                                class="w-full py-4 bg-aviary-timber/40 hover:bg-aviary-blue text-aviary-feather/60 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-full border border-aviary-brass/10">
                            Restore Condition Rings
                        </button>
                        <button wire:click="runProcessLostBirds" 
                                class="w-full py-4 bg-black/40 hover:bg-purple-900 text-purple-400 hover:text-white font-industrial font-black text-xs rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-full border border-purple-500/20">
                            Process Stray Sightings
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
            animation: spin-slow 15s linear infinite;
        }
    </style>
</div>

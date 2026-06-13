<div class="space-y-12">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             class="fixed top-20 right-4 z-50 bg-yellow-500 text-black px-6 py-3 rounded-xl shadow-2xl font-black font-industrial">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Central</div>

        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">System Overrides</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Section: Game Balance -->
                <div class="bg-slate-900 p-8 rounded-[2.5rem] border-2 border-slate-800 shadow-xl">
                    <h3 class="text-xs font-black text-yellow-500 uppercase tracking-[0.4em] mb-8 italic">Parameter Control</h3>
                    
                    <form wire:submit="updateSettings" class="space-y-6">
                        @foreach($settings as $key => $value)
                            <div class="bg-black/30 p-4 rounded-2xl border border-slate-800">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1 italic">{{ str_replace('_', ' ', $key) }}</label>
                                <input wire:model="settings.{{ $key }}" type="number" 
                                       class="w-full bg-slate-950 border-none rounded-xl p-3 text-white font-bold focus:ring-2 focus:ring-yellow-500 transition-all">
                            </div>
                        @endforeach
                        
                        <button type="submit" 
                                class="w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-xl shadow-yellow-500/10 uppercase italic tracking-widest">
                            Apply Real-time Sync
                        </button>
                    </form>
                </div>

                <!-- Section: Temporal Controls -->
                <div class="bg-slate-900 p-8 rounded-[2.5rem] border-2 border-slate-800 shadow-xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-black text-yellow-500 uppercase tracking-[0.4em] mb-8 italic">Temporal Sequence</h3>
                        
                        <div class="bg-black/40 p-8 rounded-[2rem] border border-yellow-500/20 text-center space-y-6">
                            <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto border-2 border-yellow-500/30">
                                <svg class="w-8 h-8 text-yellow-500 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-industrial font-black text-white text-xl uppercase italic">Force Maturation</p>
                                <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mt-2 leading-relaxed italic">Instantly trigger the hourly growth and energy recovery protocol across the entire network.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                        <button wire:click="runMaturation" 
                                class="w-full py-4 bg-white hover:bg-indigo-600 hover:text-white text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest">
                            Execute Lifecycle
                        </button>
                        <button wire:click="runMarketTick" 
                                class="w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest">
                            Execute Market Tick
                        </button>
                        <button wire:click="runPassiveIncome" 
                                class="w-full py-4 bg-green-600 hover:bg-green-500 text-white font-industrial font-black text-sm rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-1 md:col-span-2">
                            Distribute Passive Income
                        </button>
                        <button wire:click="runEnergyRecovery" 
                                class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-industrial font-black text-sm rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-widest col-span-1 md:col-span-2">
                            Recover Vitality Protocol
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

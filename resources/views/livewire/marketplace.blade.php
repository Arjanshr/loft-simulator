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

    <!-- Global Layout for Marketplace -->
    <div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Exchange</div>
        
        <div class="relative z-10">
            <livewire:my-listings />

            <div class="flex items-center gap-4 mb-8 mt-16 px-2">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest">Global Terminal</h2>
                <div class="flex-1 h-[1px] bg-slate-800"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($listings as $listing)
                    <div class="bg-slate-900 rounded-[2rem] border-2 border-slate-800 p-8 hover:border-yellow-500/30 transition-all duration-300 shadow-xl flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-xl font-industrial font-black text-white italic tracking-widest uppercase">{{ $listing->pigeon->name }}</h3>
                                    <div class="flex gap-2 mt-2">
                                        <span class="text-[9px] font-black bg-yellow-500 text-black px-2 py-0.5 rounded italic">LV.{{ $listing->pigeon->level }}</span>
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest border border-slate-800 px-2 py-0.5 rounded-full">{{ $listing->pigeon->rarity }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-black text-slate-600 uppercase block mb-1">Asking Price</span>
                                    <span class="text-2xl font-industrial font-black text-yellow-500">{{ number_format($listing->price) }}💰</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-[10px] font-black uppercase tracking-widest mb-8 text-slate-500 bg-black/30 p-4 rounded-2xl border border-slate-800">
                                <div>🏃 SPD: <span class="text-white">{{ $listing->pigeon->speed }}</span></div>
                                <div>🔋 POW: <span class="text-white">{{ $listing->pigeon->endurance }}</span></div>
                                <div>🧭 DIR: <span class="text-white">{{ $listing->pigeon->navigation }}</span></div>
                                <div>🧘 MND: <span class="text-white">{{ $listing->pigeon->temperament }}</span></div>
                            </div>
                            
                            <!-- Visual Stats Summary -->
                            <div class="flex justify-between items-center px-2 mb-8">
                                <div class="text-center">
                                    <span class="text-[8px] font-black text-slate-600 block uppercase mb-1">Beauty</span>
                                    <span class="text-xs font-black text-white">{{ number_format($listing->pigeon->beauty, 1) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-[8px] font-black text-slate-600 block uppercase mb-1">Gender</span>
                                    <span class="text-xs font-black {{ $listing->pigeon->gender == 'male' ? 'text-blue-400' : 'text-pink-400' }}">{{ strtoupper($listing->pigeon->gender) }}</span>
                                </div>
                                <div class="text-center">
                                    @php
                                        $status = 'Adult';
                                        if (!$listing->pigeon->hatch_at || $listing->pigeon->hatch_at->isFuture()) $status = 'Egg';
                                        elseif ($listing->pigeon->hatch_at->addDay()->isFuture()) $status = 'Hatch';
                                        elseif ($listing->pigeon->birth_at->addDays(4)->isFuture()) $status = 'Juv';
                                    @endphp
                                    <span class="text-[8px] font-black text-slate-600 block uppercase mb-1">Status</span>
                                    <span class="text-xs font-black text-slate-400">{{ $status }}</span>
                                </div>
                            </div>
                        </div>

                        <button wire:click="buy({{ $listing->id }})" 
                                class="w-full py-4 bg-white hover:bg-yellow-500 text-black font-industrial font-black text-sm rounded-2xl transition-all shadow-xl active:scale-95 uppercase italic tracking-[0.2em]">
                            Authorize Acquisition
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

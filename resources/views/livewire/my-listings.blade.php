<div class="text-slate-200">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Sell Form -->
        <div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-8 h-1 bg-yellow-500 rounded-full"></div>
                <h3 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest">Active Assets</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                @foreach($idlePigeons as $pigeon)
                    <div class="bg-black/30 border-2 border-slate-800 rounded-2xl p-4 flex justify-between items-center group hover:border-yellow-500/30 transition-all">
                        <div>
                            <p class="font-industrial font-black text-white uppercase tracking-wider text-sm">{{ $pigeon->name }}</p>
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">LV.{{ $pigeon->level }} • {{ $pigeon->type }}</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="number" wire:model="price.{{ $pigeon->id }}" 
                                   placeholder="PRICE" 
                                   class="bg-slate-900 border-none rounded-xl p-2 text-xs font-black text-yellow-500 w-24 text-center focus:ring-2 focus:ring-yellow-500 transition-all">
                            <button wire:click="listPigeon({{ $pigeon->id }})" 
                                    class="bg-yellow-500 text-black font-black p-2 rounded-xl hover:bg-yellow-400 transition shadow-lg shadow-yellow-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
                @if($idlePigeons->isEmpty())
                    <div class="p-8 border-2 border-dashed border-slate-800 rounded-[2rem] text-center">
                        <p class="text-xs font-black text-slate-600 uppercase tracking-[0.2em]">No idle units available for deployment to exchange</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- My Active Listings -->
        <div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-8 h-1 bg-yellow-500 rounded-full"></div>
                <h3 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest">Market Presence</h3>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @foreach($myListings as $listing)
                    <div class="bg-slate-900 border-2 border-slate-800 rounded-2xl p-4 flex justify-between items-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 text-4xl font-industrial font-black italic select-none pointer-events-none uppercase">Selling</div>
                        <div class="relative z-10">
                            <h4 class="font-industrial font-black text-white uppercase tracking-wider text-sm">{{ $listing->pigeon->name }}</h4>
                            @php
                                $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                            @endphp
                            <p class="text-[9px] font-black text-yellow-500/50 uppercase tracking-widest italic">
                                EXPIRES IN: {{ $remainingSecs > 0 ? gmdate("H:i:s", $remainingSecs) : 'EXPIRED' }}
                            </p>
                        </div>
                        <div class="relative z-10 text-xl font-industrial font-black text-yellow-500">
                            {{ number_format($listing->price) }}💰
                        </div>
                    </div>
                @endforeach
                @if($myListings->isEmpty())
                    <div class="p-8 border-2 border-dashed border-slate-800 rounded-[2rem] text-center">
                        <p class="text-xs font-black text-slate-600 uppercase tracking-[0.2em]">No active listings found in global terminal</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

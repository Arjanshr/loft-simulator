<div class="space-y-12 font-sans text-slate-300">
    <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden galvanized-border">
        <div class="absolute top-0 right-0 p-4 md:p-10 opacity-[0.03] text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">History</div>

        <div class="relative z-10">
            <div class="flex items-center gap-6 mb-10 md:mb-16">
                <div class="w-12 h-1.5 bg-aviary-brass rounded-full shadow-[0_0_15px_#b8860b]"></div>
                <div>
                    <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight mb-2">The Daily Chronicle</h2>
                    <p class="text-aviary-feather/40 text-[9px] md:text-[11px] font-black uppercase tracking-[0.4em] italic">Official Loft Ledger • Verified Historical Records</p>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block bg-aviary-oak/40 rounded-[3rem] border border-aviary-brass/10 overflow-hidden shadow-inner">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-aviary-timber/60 border-b border-aviary-brass/10">
                            <th class="px-10 py-8 text-[11px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] italic">Sequence & Date</th>
                            <th class="px-10 py-8 text-[11px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] italic">Event Log Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-aviary-brass/5">
                        @forelse($activities as $activity)
                            <tr class="group hover:bg-aviary-blue/5 transition-all duration-300">
                                <td class="px-10 py-8 whitespace-nowrap">
                                    <span class="font-mono text-[11px] font-bold text-aviary-brass drop-shadow-sm italic">{{ $activity->created_at->format('Y-m-d H:i:s') }}</span>
                                    <span class="block text-[9px] text-aviary-feather/30 font-bold mt-1 uppercase italic tracking-tighter">{{ $activity->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex items-start gap-4">
                                        <div class="w-1.5 h-1.5 rounded-full bg-aviary-blue/20 mt-1.5 group-hover:bg-aviary-blue transition-colors"></div>
                                        <p class="text-sm font-bold text-aviary-feather/60 group-hover:text-white transition-colors leading-relaxed italic">{{ $activity->description }}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-10 py-24 text-center">
                                    <p class="font-industrial font-black text-aviary-feather/10 text-4xl uppercase italic tracking-widest">Registry Clear</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View -->
            <div class="md:hidden space-y-6">
                @forelse($activities as $activity)
                    <div class="bg-aviary-oak/60 p-8 rounded-[2rem] border border-aviary-brass/10 shadow-xl group active:scale-[0.98] transition-all galvanized-border">
                        <div class="flex justify-between items-center mb-4 border-b border-aviary-brass/5 pb-4">
                            <span class="font-mono text-[10px] font-bold text-aviary-brass italic">{{ $activity->created_at->format('m-d H:i') }}</span>
                            <span class="text-[8px] text-aviary-feather/30 font-black uppercase italic">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1 h-auto bg-aviary-blue/20 rounded-full"></div>
                            <p class="text-xs font-bold text-aviary-feather/60 leading-relaxed group-active:text-white transition-colors italic">{{ $activity->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="py-20 border-2 border-dashed border-aviary-brass/10 rounded-[3rem] text-center bg-aviary-oak/10">
                        <p class="font-industrial font-black text-aviary-feather/20 text-base uppercase italic tracking-widest">Loft ledger is empty</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 px-6">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

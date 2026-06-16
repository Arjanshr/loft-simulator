<div class="space-y-12 font-sans text-slate-300">
    <div class="bg-[#050a0a] p-6 md:p-10 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 md:p-10 opacity-5 text-4xl md:text-9xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">History</div>

        <div class="relative z-10">
            <div class="flex items-center gap-6 mb-10 md:mb-16">
                <div class="w-12 h-1 bg-[#b8860b] rounded-full shadow-[0_0_15px_rgba(184,134,11,0.3)]"></div>
                <h2 class="text-2xl md:text-4xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight">Loft Ledger</h2>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block bg-black/40 rounded-[3rem] border border-[#b8860b]/10 overflow-hidden shadow-inner">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-black/60 border-b border-[#b8860b]/10">
                            <th class="px-10 py-6 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Date & Time</th>
                            <th class="px-10 py-6 text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Entry Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($activities as $activity)
                            <tr class="group hover:bg-[#b8860b]/5 transition-all duration-300">
                                <td class="px-10 py-6 whitespace-nowrap">
                                    <span class="font-industrial text-[11px] font-black text-[#b8860b] italic">{{ $activity->created_at->format('Y-m-d H:i:s') }}</span>
                                    <span class="block text-[9px] text-slate-600 font-bold mt-1 uppercase italic tracking-tighter">{{ $activity->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-10 py-6">
                                    <p class="text-sm font-bold text-slate-400 group-hover:text-white transition-colors leading-relaxed">{{ $activity->description }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-10 py-20 text-center">
                                    <p class="font-industrial font-black text-slate-800 text-3xl uppercase italic tracking-widest opacity-20">No entries recorded</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View -->
            <div class="md:hidden space-y-6">
                @forelse($activities as $activity)
                    <div class="bg-[#0a1414] p-6 rounded-3xl border border-[#b8860b]/10 shadow-lg group active:scale-[0.98] transition-all">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-industrial text-[10px] font-black text-[#b8860b] italic">{{ $activity->created_at->format('m-d H:i') }}</span>
                            <span class="text-[8px] text-slate-600 font-black uppercase italic">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 leading-relaxed group-active:text-white transition-colors">{{ $activity->description }}</p>
                    </div>
                @empty
                    <div class="py-20 border-2 border-dashed border-[#b8860b]/10 rounded-[2rem] text-center bg-black/10">
                        <p class="font-industrial font-black text-slate-800 text-base uppercase italic tracking-widest">Loft ledger is empty</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 px-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

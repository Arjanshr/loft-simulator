<div class="space-y-12">
    <div class="bg-slate-950 p-6 md:p-10 rounded-[2rem] md:rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 md:p-8 opacity-5 text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Archive</div>

        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-8 md:mb-12">
                <div class="w-8 md:w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-tight">Operational Logs</h2>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block bg-black/40 rounded-[2.5rem] border border-slate-800 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Temporal Stamp</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Event Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @forelse($activities as $activity)
                            <tr class="group hover:bg-yellow-500/5 transition-colors">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="font-industrial text-[10px] font-black text-yellow-500 italic">{{ $activity->created_at->format('Y-m-d H:i:s') }}</span>
                                    <span class="block text-[8px] text-slate-600 font-bold mt-1 uppercase">{{ $activity->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-300 group-hover:text-white transition-colors">{{ $activity->description }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-8 py-12 text-center">
                                    <p class="font-industrial font-black text-slate-700 text-xl uppercase italic tracking-widest">No archival data found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View -->
            <div class="md:hidden space-y-4">
                @forelse($activities as $activity)
                    <div class="bg-slate-900/50 p-5 rounded-2xl border border-slate-800">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-industrial text-[9px] font-black text-yellow-500 italic">{{ $activity->created_at->format('m-d H:i:s') }}</span>
                            <span class="text-[7px] text-slate-600 font-black uppercase">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-300">{{ $activity->description }}</p>
                    </div>
                @empty
                    <div class="p-8 border-2 border-dashed border-slate-800 rounded-2xl text-center">
                        <p class="font-industrial font-black text-slate-700 text-sm uppercase italic">No archival data</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 px-2">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

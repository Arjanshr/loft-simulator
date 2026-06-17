<div class="space-y-12 font-sans text-slate-300">
    <div class="parchment-panel p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden galvanized-border">
        <!-- Background Decorative Element -->
        <div class="absolute top-0 right-0 p-8 opacity-[0.03] text-8xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Registry</div>

        <div class="relative z-10">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16 border-b border-aviary-brass/10 pb-8">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-1.5 bg-aviary-brass rounded-full shadow-[0_0_15px_#b8860b]"></div>
                    <div>
                        <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">The Fancier's Guide</h2>
                        <p class="text-[10px] md:text-xs font-black text-aviary-feather/40 uppercase tracking-[0.4em] italic">Official Knowledge Base & Tactical Ledger</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-4 bg-black/20 px-6 py-3 rounded-2xl border border-aviary-brass/10">
                    <span class="text-3xl">📜</span>
                    <div class="text-left">
                        <p class="text-[9px] font-black text-aviary-brass uppercase tracking-widest leading-none mb-1">Status</p>
                        <p class="text-xs font-industrial font-black text-white italic uppercase">Verified Records</p>
                    </div>
                </div>
            </div>

            <!-- Knowledge Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-12">
                @foreach($faqs as $category => $items)
                    <div class="space-y-8">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span>
                            <h3 class="text-xs font-black text-aviary-blue uppercase tracking-[0.4em] italic border-b border-aviary-blue/20 pb-2 flex-1">{{ $category }}</h3>
                        </div>
                        
                        <div class="space-y-4" x-data="{ open: null }">
                            @foreach($items as $faq)
                                <div class="bg-aviary-oak/40 border border-aviary-brass/10 rounded-2xl overflow-hidden hover:border-aviary-blue/30 transition-all duration-500 shadow-xl group">
                                    <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" 
                                            class="w-full text-left p-6 flex justify-between items-center group/btn">
                                        <span class="text-xs font-industrial font-black uppercase tracking-widest text-aviary-feather/80 group-hover:text-white transition-colors italic leading-relaxed">{{ $faq->question }}</span>
                                        <div class="w-8 h-8 rounded-lg bg-black/20 flex items-center justify-center border border-aviary-brass/10 group-hover:border-aviary-blue/30 transition-all">
                                            <span class="font-industrial text-aviary-brass transform transition-transform duration-500 text-xl leading-none" :class="open === {{ $faq->id }} ? 'rotate-180 text-aviary-blue' : ''">⌄</span>
                                        </div>
                                    </button>
                                    <div x-show="open === {{ $faq->id }}" x-cloak
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 max-h-0"
                                         x-transition:enter-end="opacity-100 max-h-[1000px]"
                                         class="px-6 pb-8 text-aviary-feather/60 text-sm font-medium border-t border-aviary-brass/10 pt-6 leading-relaxed bg-black/20 italic font-sans">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer: Tactical Disclaimer -->
            <div class="mt-20 pt-10 border-t border-aviary-brass/10 text-center">
                <p class="text-[9px] font-black text-aviary-feather/20 uppercase tracking-[0.6em] italic">All records are current as of the latest Registry Update. Consult your local Loft Manager for real-time tactical adjustments.</p>
            </div>
        </div>
    </div>
</div>

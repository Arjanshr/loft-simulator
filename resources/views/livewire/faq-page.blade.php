<div class="space-y-12 font-sans text-slate-300">
    <div class="bg-[#050a0a] p-10 rounded-[3rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">Knowledge</div>

        <div class="relative z-10">
            <div class="flex items-center gap-6 mb-16">
                <div class="w-12 h-1 bg-[#b8860b] rounded-full shadow-[0_0_15px_rgba(184,134,11,0.3)]"></div>
                <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Knowledge Base</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                @foreach($faqs as $category => $items)
                    <div class="space-y-8">
                        <h3 class="text-[10px] font-black text-[#b8860b] uppercase tracking-[0.4em] mb-6 ml-2 italic border-b-2 border-[#b8860b]/20 pb-3 inline-block">{{ $category }} Records</h3>
                        <div class="space-y-4" x-data="{ open: null }">
                            @foreach($items as $faq)
                                <div class="bg-black/30 border border-white/5 rounded-[1.5rem] overflow-hidden hover:border-[#b8860b]/30 transition-all duration-300 shadow-lg">
                                    <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" 
                                            class="w-full text-left p-6 font-bold text-slate-300 flex justify-between items-center group">
                                        <span class="text-xs md:text-sm uppercase tracking-widest group-hover:text-white transition-colors italic leading-relaxed">{{ $faq->question }}</span>
                                        <span class="font-industrial text-[#b8860b] transform transition-transform duration-500 text-xl" :class="open === {{ $faq->id }} ? 'rotate-180' : ''">⌄</span>
                                    </button>
                                    <div x-show="open === {{ $faq->id }}" x-cloak
                                         x-transition:enter="transition ease-out duration-500"
                                         x-transition:enter-start="opacity-0 max-h-0"
                                         x-transition:enter-end="opacity-100 max-h-[1000px]"
                                         class="px-6 pb-8 text-slate-500 text-sm font-medium border-t border-white/5 pt-6 leading-relaxed bg-black/20 italic">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

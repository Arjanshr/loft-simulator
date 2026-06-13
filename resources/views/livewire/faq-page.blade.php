<div class="space-y-12">
    <div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Database</div>

        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Intelligence Hub</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                @foreach($faqs as $category => $items)
                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-yellow-500 uppercase tracking-[0.4em] mb-4 ml-2 italic underline underline-offset-8">{{ $category }} Protocol</h3>
                        <div class="space-y-4" x-data="{ open: null }">
                            @foreach($items as $faq)
                                <div class="bg-black/40 border-2 border-slate-800 rounded-[1.5rem] overflow-hidden hover:border-yellow-500/20 transition-all duration-300">
                                    <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" 
                                            class="w-full text-left p-6 font-bold text-white flex justify-between items-center group">
                                        <span class="text-sm uppercase tracking-wide group-hover:text-yellow-400 transition-colors">{{ $faq->question }}</span>
                                        <span class="font-industrial text-yellow-500 transform transition-transform duration-300" :class="open === {{ $faq->id }} ? 'rotate-45' : ''">+</span>
                                    </button>
                                    <div x-show="open === {{ $faq->id }}" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 -translate-y-4"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="px-6 pb-6 text-slate-500 text-sm font-medium border-t border-slate-800/50 pt-4 leading-relaxed">
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

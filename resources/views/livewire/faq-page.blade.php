<div class="p-6 max-w-4xl mx-auto text-slate-200">
    @foreach($faqs as $category => $items)
        <div class="mb-8">
            <h2 class="text-2xl font-black text-yellow-500 mb-4">{{ $category }}</h2>
            <div class="space-y-4" x-data="{ open: null }">
                @foreach($items as $faq)
                    <div class="bg-slate-900 border border-slate-700 rounded-lg shadow-sm">
                        <button @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" class="w-full text-left p-4 font-bold text-white flex justify-between items-center">
                            {{ $faq->question }}
                            <span x-show="open !== {{ $faq->id }}">+</span>
                            <span x-show="open === {{ $faq->id }}">-</span>
                        </button>
                        <div x-show="open === {{ $faq->id }}" class="p-4 pt-0 text-slate-400 text-sm">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

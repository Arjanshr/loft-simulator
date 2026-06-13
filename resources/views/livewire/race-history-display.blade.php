<div class="bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-700">
    <h2 class="text-xl font-bold text-white mb-6">Race History</h2>
    <div class="space-y-3">
        @forelse($histories as $history)
            <div class="flex justify-between items-center text-sm border-b border-slate-700 pb-3">
                <div>
                    <span class="font-bold text-white">{{ $history->race_title }}</span>
                    <p class="text-xs text-slate-400">{{ $history->pigeon_name }} • Finished #{{ $history->position }}</p>
                </div>
                <div class="text-yellow-500 font-black">
                    +{{ number_format($history->payout) }} 💰
                </div>
            </div>
        @empty
            <p class="text-slate-500 text-sm italic">No races completed yet.</p>
        @endforelse
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold mb-4">Race History</h2>
    <div class="space-y-3">
        @forelse($histories as $history)
            <div class="flex justify-between items-center text-sm border-b pb-2">
                <div>
                    <span class="font-bold text-gray-800">{{ $history->race_title }}</span>
                    <p class="text-xs text-gray-500">{{ $history->pigeon_name }} • Finished #{{ $history->position }}</p>
                </div>
                <div class="text-green-600 font-bold">
                    +{{ number_format($history->payout) }}
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm">No races completed yet.</p>
        @endforelse
    </div>
</div>

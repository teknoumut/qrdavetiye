<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-8 mb-8">
            <div class="flex items-center gap-5">
                <span class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-bold text-white shadow-lg overflow-hidden">
                    @if($user->photo_url)
                        <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="w-full h-full bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center">{{ $user->initial }}</span>
                    @endif
                </span>
                <div>
                    <h1 class="text-2xl font-bold text-night-900 dark:text-cream-100">{{ $user->name }}</h1>
                    <p class="text-night-400 dark:text-cream-400">Üye: {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        @if ($user->hasActivePlan())
            <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-6 mb-8">
                <h2 class="text-lg font-bold text-night-900 dark:text-cream-100 mb-4">Aktif Plan</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-night-800 dark:text-cream-200">{{ $user->plan->name ?? 'Plan' }}</p>
                        <p class="text-sm text-night-400 dark:text-cream-400">
                            {{ $user->subscription_start?->format('d M Y') }} -
                            {{ $user->subscription_end?->format('d M Y') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        @if($user->isSubscribed()) bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300
                        @elseif($user->isCancelled()) bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300
                        @else bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 @endif">
                        {{ $user->subscriptionStatusLabel() }}
                    </span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-6 mb-8">
            <h2 class="text-lg font-bold text-night-900 dark:text-cream-100 mb-4">Faturalar</h2>
            @forelse ($invoices as $invoice)
                <div class="flex items-center justify-between py-3 border-b border-cream-100 dark:border-night-700 last:border-0">
                    <div>
                        <p class="font-semibold text-night-800 dark:text-cream-200">{{ $invoice->invoice_no }}</p>
                        <p class="text-xs text-night-400 dark:text-cream-400">{{ $invoice->created_at->format('d M Y') }} - {{ $invoice->plan->name ?? 'Plan' }} ({{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }})</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-night-900 dark:text-cream-100">{{ number_format($invoice->amount, 2) }} TL</span>
                        @auth
                            @if (auth()->id() === $user->id)
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-sm text-gold-600 dark:text-gold-400 hover:underline">Görüntüle</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <p class="text-night-400 dark:text-cream-400 text-sm">Henüz fatura bulunmuyor.</p>
            @endforelse
        </div>

        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-6">
            <h2 class="text-lg font-bold text-night-900 dark:text-cream-100 mb-4">Yorumlar</h2>
            @forelse ($reviews as $review)
                <div class="py-3 border-b border-cream-100 dark:border-night-700 last:border-0">
                    <div class="flex items-center gap-1 mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-cream-300 dark:text-night-500' }}">★</span>
                        @endfor
                    </div>
                    <p class="text-sm text-night-500 dark:text-cream-400">{{ Str::limit($review->content, 120) }}</p>
                    <p class="text-xs text-night-400 dark:text-cream-500 mt-1">{{ $review->created_at->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-night-400 dark:text-cream-400 text-sm">Henüz yorum yapılmamış.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-night-900 dark:text-cream-100">Fatura #{{ $invoice->invoice_no }}</h1>
                    <p class="text-night-400 dark:text-cream-400">{{ $invoice->created_at->format('d F Y') }}</p>
                </div>
                <a href="{{ route('invoices.download', $invoice) }}" class="px-5 py-2.5 bg-gradient-to-r from-gold-400 to-rose-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    PDF İndir
                </a>
            </div>

            <div class="border-t border-cream-200 dark:border-night-700 pt-6">
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-night-400 dark:text-cream-500 uppercase tracking-wider mb-1">Fatura Eden</p>
                        <p class="font-semibold text-night-900 dark:text-cream-100">{{ config('app.name') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-night-400 dark:text-cream-500 uppercase tracking-wider mb-1">Müşteri</p>
                        <p class="font-semibold text-night-900 dark:text-cream-100">{{ $invoice->user->name }}</p>
                        <p class="text-sm text-night-500 dark:text-cream-400">{{ $invoice->user->email }}</p>
                    </div>
                </div>

                <div class="bg-cream-50 dark:bg-night-900/50 rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-between py-2 border-b border-cream-200 dark:border-night-700">
                        <span class="font-semibold text-night-700 dark:text-cream-200">Plan</span>
                        <span class="text-night-900 dark:text-cream-100">{{ $invoice->plan->name ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-cream-200 dark:border-night-700">
                        <span class="font-semibold text-night-700 dark:text-cream-200">Dönem</span>
                        <span class="text-night-900 dark:text-cream-100">{{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-cream-200 dark:border-night-700">
                        <span class="font-semibold text-night-700 dark:text-cream-200">Ödeme Yöntemi</span>
                        <span class="text-night-900 dark:text-cream-100">{{ $invoice->gateway }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-cream-200 dark:border-night-700">
                        <span class="font-semibold text-night-700 dark:text-cream-200">Durum</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ ucfirst($invoice->status) }}</span>
                    </div>
                    @if ($invoice->transaction_id)
                    <div class="flex items-center justify-between py-2">
                        <span class="font-semibold text-night-700 dark:text-cream-200">İşlem ID</span>
                        <span class="text-xs text-night-500 dark:text-cream-400 font-mono">{{ $invoice->transaction_id }}</span>
                    </div>
                    @endif
                </div>

                <div class="flex items-center justify-between py-2">
                    <span class="font-semibold text-night-700 dark:text-cream-200">Ara Toplam</span>
                    <span class="text-night-900 dark:text-cream-100">{{ number_format($invoice->amount, 2) }} TL</span>
                </div>
                @if($invoice->tax_rate > 0)
                <div class="flex items-center justify-between py-2">
                    <span class="font-semibold text-night-700 dark:text-cream-200">KDV ({{ number_format($invoice->tax_rate, 0) }}%)</span>
                    <span class="text-night-900 dark:text-cream-100">{{ number_format($invoice->tax_amount, 2) }} TL</span>
                </div>
                @endif
                <div class="flex items-center justify-between py-3 border-t border-cream-200 dark:border-night-700">
                    <span class="text-lg font-bold text-night-900 dark:text-cream-100">Toplam</span>
                    <span class="text-2xl font-black text-night-900 dark:text-cream-100">{{ number_format($invoice->amount + $invoice->tax_amount, 2) }} TL</span>
                </div>
            </div>

            @if($canRequestRefund)
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-500/5 border border-blue-200 dark:border-blue-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1">7 Gün İade Hakkı</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mb-3">Bu fatura için iade talebinde bulunabilirsiniz. İade onaylandığında aboneliğiniz iptal edilecektir.</p>
                            <form method="POST" action="{{ route('invoices.refund-request', $invoice) }}" onsubmit="return confirm('İade talebinde bulunmak istediğinize emin misiniz?')">
                                @csrf
                                <div class="mb-2">
                                    <textarea name="reason" rows="2" class="w-full px-3 py-2 rounded-lg border border-blue-200 dark:border-blue-500/20 bg-white dark:bg-night-900 text-sm text-night-900 dark:text-cream-100 placeholder:text-night-300 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 resize-none" placeholder="İade sebebiniz (isteğe bağlı)"></textarea>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all">
                                    İade Talep Et
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($invoice->refund_status === 'requested')
                <div class="mt-6 p-4 bg-amber-50 dark:bg-amber-500/5 border border-amber-200 dark:border-amber-500/20 rounded-xl">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        İade talebiniz alınmıştır, işleme alınmayı bekliyor.
                    </p>
                </div>
            @elseif($invoice->refund_status === 'refunded')
                <div class="mt-6 p-4 bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-200 dark:border-emerald-500/20 rounded-xl">
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300 flex items-center gap-2">
                        ✅ Bu fatura iade edilmiştir ({{ $invoice->refunded_at?->format('d.m.Y') }}).
                    </p>
                </div>
            @elseif($invoice->refund_status === 'rejected')
                <div class="mt-6 p-4 bg-red-50 dark:bg-red-500/5 border border-red-200 dark:border-red-500/20 rounded-xl">
                    <p class="text-sm font-semibold text-red-700 dark:text-red-300">❌ İade talebiniz reddedilmiştir.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

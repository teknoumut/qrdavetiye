<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 p-6 sm:p-8 shadow-sm mb-6">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-night-900 dark:text-cream-100">EFT / Havale ile Öde</h1>
                <p class="text-night-400 dark:text-night-500 text-sm mt-1">{{ $plan->name }} Plan — {{ $interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-500/10 dark:to-emerald-500/5 rounded-xl border border-emerald-200 dark:border-emerald-500/20 p-5 mb-6">
                <div class="space-y-1.5 text-sm mb-3">
                    <div class="flex items-center justify-between text-night-500 dark:text-night-400">
                        <span>Ara Toplam</span>
                        <span>{{ number_format($price, 2) }} TL</span>
                    </div>
                    @if($taxRate > 0)
                    <div class="flex items-center justify-between text-night-500 dark:text-night-400">
                        <span>KDV ({{ number_format($taxRate, 0) }}%)</span>
                        <span>{{ number_format($taxAmount, 2) }} TL</span>
                    </div>
                    @endif
                    <div class="border-t border-emerald-200 dark:border-emerald-500/20 pt-1.5"></div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-black text-night-900 dark:text-cream-100">{{ number_format($total, 2) }} TL</div>
                    <div class="text-sm text-night-400 dark:text-night-500 mt-1">KDV Dahil Toplam Tutar</div>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                @if($bankName)
                <div>
                    <label class="block text-xs font-semibold text-night-400 dark:text-night-500 uppercase tracking-wider mb-1.5">Banka</label>
                    <div class="p-3 sm:p-4 rounded-xl bg-night-50 dark:bg-night-700/50 border border-cream-200 dark:border-night-700 font-semibold text-night-900 dark:text-cream-100 text-sm sm:text-base">{{ $bankName }}</div>
                </div>
                @endif
                <div>
                    <label class="block text-xs font-semibold text-night-400 dark:text-night-500 uppercase tracking-wider mb-1.5">IBAN</label>
                    <div class="p-3 sm:p-4 rounded-xl bg-night-50 dark:bg-night-700/50 border border-cream-200 dark:border-night-700 font-mono font-bold text-night-900 dark:text-cream-100 text-sm sm:text-base select-all cursor-pointer" onclick="navigator.clipboard.writeText(this.textContent.trim()).then(() => showCopiedToast())">{{ $iban }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-night-400 dark:text-night-500 uppercase tracking-wider mb-1.5">Alıcı Adı</label>
                    <div class="p-3 sm:p-4 rounded-xl bg-night-50 dark:bg-night-700/50 border border-cream-200 dark:border-night-700 font-semibold text-night-900 dark:text-cream-100 text-sm sm:text-base">{{ $bankHolder }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-night-400 dark:text-night-500 uppercase tracking-wider mb-1.5">Açıklama</label>
                    <div class="p-3 sm:p-4 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 font-mono font-bold text-amber-800 dark:text-amber-300 text-sm sm:text-base select-all">{{ $orderNo }}</div>
                    <p class="text-xs text-night-400 dark:text-night-500 mt-1.5">EFT/Havale açıklama kısmına yukarıdaki sipariş numarasını yazmayı unutmayın.</p>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4 text-xs sm:text-sm text-amber-800 dark:text-amber-300 flex items-start gap-3 mb-6">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <div>
                    <strong>Önemli:</strong> Havale işleminizi tamamladıktan sonra aşağıdaki "Ödeme Bildir" butonuna tıklayarak bildirim gönderin. Ödemeniz admin tarafından onaylandığında aboneliğiniz aktifleşecektir.
                </div>
            </div>

            <form method="POST" action="{{ route('payment.eft.notify') }}">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="interval" value="{{ $interval }}">
                <input type="hidden" name="order_no" value="{{ $orderNo }}">
                <input type="hidden" name="amount" value="{{ $total }}">

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-night-600 dark:text-cream-300 mb-1.5">Not (isteğe bağlı)</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-500/20 outline-none transition-all resize-none" placeholder="Ödeme bilgisi veya ek not..."></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-white text-sm bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-500/20 hover:shadow-emerald-300/50 dark:hover:shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ödeme Bildir
                </button>
            </form>
        </div>
    </div>

    <script>
        function showCopiedToast() {
            var t = document.createElement('div');
            t.textContent = 'IBAN kopyalandı!';
            t.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-night-900 dark:bg-cream-100 text-white dark:text-night-900 px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg z-50 animate-fade-in';
            document.body.appendChild(t);
            setTimeout(function() { t.remove(); }, 2000);
        }
    </script>
</x-app-layout>

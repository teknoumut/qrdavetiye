<x-app-layout>
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 p-8 sm:p-10 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <h1 class="text-2xl font-extrabold text-night-900 dark:text-cream-100 mb-2">Ödeme Bildirimi Alındı!</h1>
            <p class="text-night-400 dark:text-night-500 text-sm mb-6">Ödeme bildiriminiz başarıyla iletilmiştir. Aboneliğiniz admin onayından sonra aktifleşecek.</p>

            <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4 mb-6 text-left space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-night-400 dark:text-night-500">Sipariş No</span>
                    <span class="font-mono font-bold text-night-900 dark:text-cream-100">{{ $orderNo }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-night-400 dark:text-night-500">Plan</span>
                    <span class="font-semibold text-night-900 dark:text-cream-100">{{ $plan->name }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-night-400 dark:text-night-500">Durum</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Onay Bekliyor
                    </span>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-500/5 border border-blue-200 dark:border-blue-500/20 rounded-xl p-4 text-xs sm:text-sm text-blue-800 dark:text-blue-300 flex items-start gap-3 mb-6 text-left">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong>Sonraki Adım:</strong> Ödemeniz admin tarafından kontrol edilip onaylandığında panelinizde yeşil bir bildirim göreceksiniz. Bu sayfayı kapatabilir, panelinize giriş yaptığınızda durumu görebilirsiniz.
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-gold-400 to-rose-500 hover:opacity-90 transition-all shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Paneli Görüntüle
            </a>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 p-6 sm:p-8 shadow-sm">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-night-900 dark:text-cream-100">{{ $plan->name }} {{ __('Plan') }}</h1>
                <p class="text-night-400 dark:text-night-500 text-sm mt-1">{{ $plan->description }}</p>
            </div>

            @php
                $taxRate = (float) \App\Models\Setting::getValue('tax_rate', 20);
                $monthlyTotal = round($plan->monthly_price * (1 + $taxRate / 100), 2);
                $yearlyTotal = round($plan->yearly_price * (1 + $taxRate / 100), 2);
            @endphp
            <div class="grid grid-cols-2 gap-3 mb-6">
                <a href="{{ route('payment.eft.pay', ['plan' => $plan->id, 'interval' => 'monthly']) }}"
                   class="block p-5 rounded-xl border-2 border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/50 dark:bg-emerald-500/5 text-center hover:border-emerald-400 dark:hover:border-emerald-400 transition-all group">
                    <div class="text-2xl font-black text-night-900 dark:text-cream-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ formatCurrency($monthlyTotal) }}</div>
                    <div class="text-xs text-night-400 dark:text-night-500 mt-1">{{ __('Aylık (KDV Dahil)') }}</div>
                </a>
                <a href="{{ route('payment.eft.pay', ['plan' => $plan->id, 'interval' => 'yearly']) }}"
                   class="block p-5 rounded-xl border-2 border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/50 dark:bg-emerald-500/5 text-center hover:border-emerald-400 dark:hover:border-emerald-400 transition-all group relative">
                    @if($plan->yearly_price < $plan->monthly_price * 12)
                        <span class="absolute -top-2.5 right-3 bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ round((1 - $plan->yearly_price / ($plan->monthly_price * 12)) * 100) }}% {{ __('TASARRUF') }}</span>
                    @endif
                    <div class="text-2xl font-black text-night-900 dark:text-cream-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ formatCurrency($yearlyTotal) }}</div>
                    <div class="text-xs text-night-400 dark:text-night-500 mt-1">{{ __('Yıllık (KDV Dahil)') }}</div>
                </a>
            </div>

            <ul class="space-y-2 mb-6">
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xs font-bold shrink-0">✓</span>
                    {{ $plan->max_invitations == -1 ? __('Sınırsız davetiye') : __('Maksimum :count davetiye', ['count' => $plan->max_invitations]) }}
                </li>
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xs font-bold shrink-0">✓</span>
                    {{ $plan->max_images_per_invitation == -1 ? __('Sınırsız fotoğraf') : __('Davetiye başına :count fotoğraf', ['count' => $plan->max_images_per_invitation]) }}
                </li>
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full {{ $plan->music_feature ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $plan->music_feature ? '✓' : '✗' }}</span>
                    {{ __('Müzik desteği') }}
                </li>
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full {{ $plan->video_feature ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $plan->video_feature ? '✓' : '✗' }}</span>
                    {{ __('Video desteği') }}
                </li>
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full {{ $plan->rsvp_feature ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $plan->rsvp_feature ? '✓' : '✗' }}</span>
                    {{ __('RSVP katılım takibi') }}
                </li>
                <li class="flex items-center gap-3 text-sm text-night-600 dark:text-cream-300">
                    <span class="w-5 h-5 rounded-full {{ $plan->qr_download ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-500/20 text-red-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $plan->qr_download ? '✓' : '✗' }}</span>
                    {{ __('QR kod indirme') }}
                </li>
            </ul>

            <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-200 dark:border-amber-500/20 rounded-xl p-4 text-sm text-amber-800 dark:text-amber-300 flex items-start gap-3">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ __('Bu ödeme yönteminde EFT/Havale kullanılır. Ödeme bildiriminiz admin tarafından onaylandıktan sonra aboneliğiniz aktifleşir.') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>

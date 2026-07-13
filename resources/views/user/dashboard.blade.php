<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">{{ __('Merhaba, :name', ['name' => auth()->user()->name]) }}</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">{{ __('Davetiyelerinin genel durumu') }}</p>
            </div>
            @if(($needs_subscription && !$has_pending_payment) || $subscription_expired)
                <span class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white/60 bg-gradient-to-r from-gold-500/50 to-rose-500/50 cursor-not-allowed shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20" title="{{ __('Önce bir plan satın almalısınız') }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Yeni Davetiye') }}
                </span>
            @else
                <a href="{{ route('user.invitations.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Yeni Davetiye') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-8">
        @unless(auth()->user()->is_admin)
        @if($needs_subscription && !$has_pending_payment)
            <div class="animate-fade-in">
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 border border-gold-200 dark:border-gold-500/20">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-100 to-rose-100 dark:from-gold-500/20 dark:to-rose-500/20 flex items-center justify-center shrink-0 text-lg">🎉</div>
                        <div class="flex-1">
                            <p class="font-semibold text-gold-800 dark:text-gold-300">{{ __('Henüz Bir Plan Seçmediniz') }}</p>
                            <p class="text-sm text-gold-700/70 dark:text-gold-400/70 mt-0.5">{{ __('Davetiye oluşturmak için bir plan satın almalısınız. Hemen planını seç, ödemeyi yap ve davetiyeni oluşturmaya başla!') }}</p>
                            <a href="{{ route('home') }}#pricing" class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-md shadow-gold-200/50 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                                {{ __('Planları Gör') }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($subscription_expired)
            <div class="animate-fade-in">
                <div class="p-4 sm:p-5 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-rose-800 dark:text-rose-300">{{ __('Üyelik Süreniz Doldu') }}</p>
                            <p class="text-sm text-rose-700/70 dark:text-rose-400/70 mt-0.5">{{ __('Mevcut davetiyelerinizi görüntüleyebilirsiniz ancak yeni davetiye oluşturmak için planınızı yenilemelisiniz.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($expiring_soon)
            <div class="animate-fade-in">
                <div class="p-4 sm:p-5 rounded-2xl bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gold-100 dark:bg-gold-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gold-600 dark:text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gold-800 dark:text-gold-300">{{ __('Üyelik Süreniz Doluyor') }}</p>
                            <p class="text-sm text-gold-700/70 dark:text-gold-400/70 mt-0.5">{{ __('Süreniz :time sona erecek.', ['time' => $subscription_end?->diffForHumans()]) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (! $needs_subscription && $plan && count($missing_features) > 0)
            <div class="space-y-3 animate-fade-in">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">📢 {{ __('Planını Kaçırma') }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($missing_features as $mf)
                    <div class="p-4 rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 flex items-center justify-center shrink-0 text-lg opacity-50 saturate-0">{{ $mf['emoji'] }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-night-700 dark:text-cream-200 text-sm">{{ $mf['label'] }} <span class="text-xs font-normal text-night-400 dark:text-cream-400">{{ __('paketine dahil değil') }}</span></p>
                            <p class="text-xs text-night-400 dark:text-cream-400 mt-0.5">{{ $mf['desc'] }}</p>
<a href="{{ $suggested_plan ? route('payment.checkout', $suggested_plan) : route('home') . '#pricing' }}" class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-gold-600 dark:text-gold-400 hover:text-gold-700 dark:hover:text-gold-300 transition-colors">
                                        {{ __('Planını Yükselt') }}
                                    </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($plan && $plan->name === 'Deneme' && $suggested_plan)
            <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-100 to-rose-100 dark:from-gold-500/20 dark:to-rose-500/20 flex items-center justify-center text-lg shrink-0">🎯</div>
                        <div>
                            <h3 class="font-bold text-night-900 dark:text-cream-100">{{ __('Sana En Uygun Plan') }}</h3>
                            <p class="text-xs text-night-400 dark:text-cream-400 mt-0.5">{{ __('Deneme süren bitmeden planını seç, davetiyen yayında kalsın') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($plans as $p)
                        @php $isBest = $p->name === 'Standart'; @endphp
                        <div class="rounded-xl border-2 p-4 text-center transition-all hover:shadow-md hover:-translate-y-0.5 {{ $isBest ? 'border-gold-400 bg-gold-50/50 dark:bg-gold-500/5 dark:border-gold-500' : 'border-cream-200 dark:border-night-700 bg-white dark:bg-night-900' }}">
                            @if($isBest)<div class="text-xs font-bold text-gold-700 dark:text-gold-400 mb-1">🔥 Popüler</div>@endif
                            <h4 class="font-bold text-night-900 dark:text-cream-100 text-base">{{ $p->name }}</h4>
                            <div class="text-xl font-extrabold text-night-900 dark:text-cream-100 mt-2">{{ formatCurrency($p->monthly_price) }}<span class="text-xs font-normal text-night-400 dark:text-cream-400">/ay</span></div>
                            <ul class="text-left mt-4 space-y-1.5 text-xs">
                                <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> {{ $p->max_invitations == -1 ? 'Sınırsız davetiye' : 'En fazla ' . $p->max_invitations . ' davetiye' }}</li>
                                <li class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> {{ $p->max_images_per_invitation == -1 ? 'Sınırsız fotoğraf' : $p->max_images_per_invitation . ' fotoğraf' }}</li>
                                <li class="flex items-center gap-1.5"><span class="{{ $p->music_feature ? 'text-emerald-500' : 'text-red-400' }} font-bold">{{ $p->music_feature ? '✓' : '✗' }}</span> Müzik</li>
                                <li class="flex items-center gap-1.5"><span class="{{ $p->video_feature ? 'text-emerald-500' : 'text-red-400' }} font-bold">{{ $p->video_feature ? '✓' : '✗' }}</span> Video</li>
                                <li class="flex items-center gap-1.5"><span class="{{ $p->cover_video_feature ? 'text-emerald-500' : 'text-red-400' }} font-bold">{{ $p->cover_video_feature ? '✓' : '✗' }}</span> Kapak videosu</li>
                                <li class="flex items-center gap-1.5"><span class="{{ $p->rsvp_feature ? 'text-emerald-500' : 'text-red-400' }} font-bold">{{ $p->rsvp_feature ? '✓' : '✗' }}</span> RSVP</li>
                                <li class="flex items-center gap-1.5"><span class="{{ $p->qr_download ? 'text-emerald-500' : 'text-red-400' }} font-bold">{{ $p->qr_download ? '✓' : '✗' }}</span> QR indirme</li>
                            </ul>
                            <a href="{{ route('payment.checkout', $p) }}" class="block mt-4 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm">{{ __('Seç') }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @endunless

        @if($payment_notification)
            <div class="animate-fade-in">
                @if($payment_notification->status === 'pending')
                    <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-amber-800 dark:text-amber-300">{{ __('Ödeme Onay Bekliyor') }}</p>
                                <p class="text-sm text-amber-700/70 dark:text-amber-400/70 mt-0.5">
                                    <strong>{{ $payment_notification->plan->name }}</strong> planı için <strong>{{ formatCurrency($payment_notification->amount) }}</strong> tutarındaki ödeme bildiriminiz (<span class="font-mono">{{ $payment_notification->order_no }}</span>) alındı, admin onayı bekleniyor.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($payment_notification->status === 'approved')
                    <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-emerald-800 dark:text-emerald-300">{{ __('Ödeme Onaylandı! 🎉') }}</p>
                                <p class="text-sm text-emerald-700/70 dark:text-emerald-400/70 mt-0.5">
                                    {{ __(":plan planına ait ödemeniz onaylandı. Aboneliğiniz aktif! Hemen davetiyeni oluşturmaya başlayabilirsin.", ['plan' => $payment_notification->plan->name]) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($payment_notification->status === 'rejected')
                    <div class="p-4 sm:p-5 rounded-2xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-red-800 dark:text-red-300">{{ __('Ödeme Reddedildi') }}</p>
                                <p class="text-sm text-red-700/70 dark:text-red-400/70 mt-0.5">
                                    <strong>{{ $payment_notification->plan->name }}</strong> {{ __('planı için yaptığınız ödeme bildirimi reddedildi.') }}
                                    @if($payment_notification->notes)
                                        <br>{{ __('Sebep:') }} {{ $payment_notification->notes }}
                                    @endif
                                    {{ __('Lütfen iletişime geçin.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @unless(auth()->user()->is_admin)
        @if ($plan && ! $needs_subscription)
            <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gold-100 to-rose-100 dark:from-gold-500/20 dark:to-rose-500/20 flex items-center justify-center text-xl shrink-0">💎</div>
                            <div>
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 class="font-bold text-night-900 dark:text-cream-100 text-lg">{{ $plan->name }} Plan</h3>
                                    @php
                                        $statusColors = ['emerald' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20', 'amber' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20', 'red' => 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20', 'gray' => 'bg-night-50 dark:bg-night-700 text-night-400 dark:text-cream-400 border-night-200 dark:border-night-600'];
                                        $statusLabels = ['active' => __('Aktif'), 'cancelled' => __('İptal Edildi'), 'expired' => __('Süresi Doldu')];
                                        $color = auth()->user()->subscriptionStatusColor();
                                        $label = auth()->user()->subscriptionStatusLabel();
                                    @endphp
                                    <span class="text-xs font-semibold px-3 py-1.5 rounded-lg border {{ $statusColors[$color] ?? $statusColors['gray'] }}">
                                        {{ $label }}
                                    </span>
                                </div>
                                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">
                                    @if ($subscription_end)
                                        @if ($is_subscribed)
                                            {{ __('Bitiş:') }} {{ $subscription_end->format('d.m.Y') }} ({{ $subscription_end->diffForHumans() }})
                                        @elseif ($is_cancelled)
                                            {{ __('Erişimin devam ediyor: :date tarihine kadar', ['date' => $subscription_end->format('d.m.Y')]) }}
                                        @elseif ($subscription_expired)
                                            {{ __(':date tarihinde sona erdi', ['date' => $subscription_end->format('d.m.Y')]) }}
                                        @endif
                                    @else
                                        {{ __('Plan aktif, bitiş tarihi bulunamadı') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if ($is_subscribed)
                                <form method="POST" action="{{ route('subscription.cancel') }}" onsubmit="return confirm('{{ __('Aboneliğinizi iptal etmek istediğinize emin misiniz? Plan özelliklerini süre sonuna kadar kullanmaya devam edebilirsiniz.') }}')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 hover:bg-red-100 dark:hover:bg-red-500/20 transition-all duration-200">
                                        {{ __('Aboneliği İptal Et') }}
                                    </button>
                                </form>
                                <a href="{{ route('home') }}#pricing" class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-md shadow-gold-200/50 transition-all duration-300 hover:shadow-lg">
                                    {{ __('Planı Yükselt') }}
                                </a>
                            @elseif ($is_cancelled)
                                <form method="POST" action="{{ route('subscription.resubscribe') }}" onsubmit="return confirm('{{ __('Aboneliğinizi yeniden aktifleştirmek istediğinize emin misiniz?') }}')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-all duration-200">
                                        {{ __('Yeniden Aktifleştir') }}
                                    </button>
                                </form>
                            @endif
                            @if ($subscription_expired || $is_cancelled)
                                <a href="{{ route('home') }}#pricing" class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-md shadow-gold-200/50 transition-all duration-300 hover:shadow-lg">
                                    {{ __('Plan Satın Al') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    @if ($subscription_start)
                        <div class="mt-4 pt-4 border-t border-cream-100 dark:border-night-700">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                                <div>
                                    <p class="text-xs text-night-400 dark:text-cream-400 font-medium">{{ __('Başlangıç') }}</p>
                                    <p class="text-sm font-semibold text-night-900 dark:text-cream-100 mt-0.5">{{ $subscription_start->format('d.m.Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-night-400 dark:text-cream-400 font-medium">{{ __('Bitiş') }}</p>
                                    <p class="text-sm font-semibold text-night-900 dark:text-cream-100 mt-0.5">{{ $subscription_end?->format('d.m.Y') ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-night-400 dark:text-cream-400 font-medium">{{ __('Durum') }}</p>
                                    <p class="text-sm font-semibold mt-0.5 {{ $is_subscribed ? 'text-emerald-600 dark:text-emerald-400' : ($is_cancelled ? 'text-amber-600 dark:text-amber-400' : ($subscription_expired ? 'text-red-600 dark:text-red-400' : 'text-night-400')) }}">
                                        {{ $label }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-night-400 dark:text-cream-400 font-medium">{{ __('Kalan Süre') }}</p>
                                    <p class="text-sm font-semibold text-night-900 dark:text-cream-100 mt-0.5">
                                        @if ($subscription_end && now()->lessThan($subscription_end))
                                            {{ now()->diffInDays($subscription_end) }} {{ __('gün') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        @endunless

        @php
            $statCards = [
                ['emoji' => '💌', 'label' => __('Toplam Davetiye'), 'value' => $total_invitations, 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'delay' => '0ms'],
                ['emoji' => '✅', 'label' => __('Yayındaki Davetiyeler'), 'value' => $published_invitations, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'delay' => '50ms'],
                ['emoji' => '👁️', 'label' => __('Toplam Görüntülenme'), 'value' => $total_views, 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'delay' => '100ms'],
                ['emoji' => '📱', 'label' => __('QR Tarama'), 'value' => $total_qr_scans, 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v4m0 0h-2m2 0h2M4 4v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H6a2 2 0 00-2 2z', 'delay' => '150ms'],
            ];
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($statCards as $card)
                <div class="group rounded-2xl p-4 sm:p-5 bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm hover:shadow-lg hover:border-gold-200 dark:hover:border-gold-500/30 transition-all duration-300 animate-scale-in hover:-translate-y-0.5" style="animation-delay: {{ $card['delay'] }}">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 flex items-center justify-center text-lg sm:text-xl group-hover:scale-110 transition-transform duration-300">
                            {{ $card['emoji'] }}
                        </div>
                        <span class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $card['value'] }}</span>
                    </div>
                    <p class="text-xs sm:text-sm text-night-400 dark:text-cream-400 font-medium">{{ $card['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            @if($upcoming_events->count() > 0)
                <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold-100 to-gold-200 dark:from-gold-500/20 dark:to-gold-500/10 flex items-center justify-center text-sm">📅</div>
                            <div>
                                <h3 class="font-bold text-night-900 dark:text-cream-100">{{ __('Yaklaşan Etkinlikler') }}</h3>
                                <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Sıradaki davetiyelerin') }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            @foreach($upcoming_events as $inv)
                                <a href="{{ route('user.invitations.edit', $inv) }}" class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50/50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 hover:border-gold-200 dark:hover:border-gold-500/30 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all duration-200 group">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-night-900 dark:text-cream-100 text-sm group-hover:text-gold-700 dark:group-hover:text-gold-400 transition-colors truncate">{{ $inv->title }}</p>
                                        <p class="text-xs text-night-400 dark:text-cream-400 mt-0.5 truncate">{{ $inv->groom_name }} & {{ $inv->bride_name }}</p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-xs font-semibold text-night-400 dark:text-cream-400 bg-white dark:bg-night-800 px-3 py-1.5 rounded-lg border border-cream-200 dark:border-night-700">{{ $inv->event_date?->format('d.m.Y') }}</span>
                                        @if($inv->is_published)
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($recent_invitations->count() > 0)
                <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden" style="animation-delay: 100ms">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-500/20 dark:to-rose-500/10 flex items-center justify-center text-sm">🕐</div>
                            <div>
                                <h3 class="font-bold text-night-900 dark:text-cream-100">{{ __('Son Davetiyeler') }}</h3>
                                <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Son eklediklerin') }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            @foreach($recent_invitations as $inv)
                                <div class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50/50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 hover:border-rose-200 dark:hover:border-rose-500/30 hover:bg-rose-50/50 dark:hover:bg-rose-500/5 transition-all duration-200 group">
                                    <div class="min-w-0">
                                        <a href="{{ route('user.invitations.edit', $inv) }}" class="font-semibold text-night-900 dark:text-cream-100 text-sm group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors truncate block">{{ $inv->title }}</a>
                                        <p class="text-xs text-night-400 dark:text-cream-400 mt-0.5">{{ __(':views görüntülenme', ['views' => $inv->views]) }}</p>
                                    </div>
                                    <div class="flex items-center gap-2.5 shrink-0">
                                        @if($inv->is_published)
                                            <a href="{{ route('user.invitations.qr', $inv) }}" class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-gold-50 dark:bg-gold-500/10 text-gold-600 dark:text-gold-400 hover:bg-gold-100 dark:hover:bg-gold-500/20 transition-colors">QR</a>
                                            <a href="{{ route('user.invitations.rsvps', $inv) }}" class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors">RSVP</a>
                                        @endif
                                        <span class="text-xs font-semibold px-3 py-1.5 rounded-lg {{ $inv->is_published ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20' : 'bg-night-50 dark:bg-night-700 text-night-400 dark:text-cream-400' }}">
                                            {{ $inv->is_published ? __('Yayında') : __('Taslak') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-500/20 dark:to-rose-500/10 flex items-center justify-center text-sm">💌</div>
                        <div>
                            <h3 class="font-bold text-night-900 dark:text-cream-100">{{ __('Son RSVP Kayıtları') }}</h3>
                            <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Davetlilerden gelen yanıtlar') }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium text-night-400 dark:text-cream-400 bg-cream-50 dark:bg-night-900 px-3 py-1.5 rounded-lg">{{ __(':total yanıt · :attending katılımcı', ['total' => $total_rsvps, 'attending' => $attending_rsvps]) }}</span>
                </div>
                @if($recent_rsvps->count() > 0)
                    <div class="space-y-2">
                        @foreach($recent_rsvps as $rsvp)
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50/50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 transition-all hover:border-emerald-200/50 dark:hover:border-emerald-500/20">
                                <div class="min-w-0">
                                    <p class="font-semibold text-night-900 dark:text-cream-100 text-sm">{{ $rsvp->name }}</p>
                                    <p class="text-xs text-night-400 dark:text-cream-400 mt-0.5 truncate">{{ $rsvp->invitation->title }} @if($rsvp->phone) · {{ $rsvp->phone }} @endif</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <span class="text-sm font-bold text-night-500 dark:text-cream-300 tabular-nums">{{ __(':count kişi', ['count' => $rsvp->guest_count]) }}</span>
                                    <span class="text-xs font-semibold px-3 py-1.5 rounded-lg
                                        @if($rsvp->status === 'attending') bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20
                                        @elseif($rsvp->status === 'not_attending') bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20
                                        @else bg-gold-50 dark:bg-gold-500/10 text-gold-700 dark:text-gold-400 border border-gold-200 dark:border-gold-500/20 @endif">
                                        @if($rsvp->status === 'attending') {{ __('Katılıyor') }}
                                        @elseif($rsvp->status === 'not_attending') {{ __('Katılmıyor') }}
                                        @else {{ __('Belki') }} @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center pt-4 mt-2">
                        <span class="text-xs text-night-400 dark:text-cream-400 font-medium">{{ __('Son 10 kayıt') }}</span>
                    </div>
                @else
                    <div class="text-center py-14">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-500/10 dark:to-rose-500/5 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">💌</span>
                        </div>
                        <p class="text-night-400 dark:text-cream-400 text-sm font-medium">{{ __('Henüz RSVP kaydı bulunmuyor') }}</p>
                        <p class="text-xs text-night-300 dark:text-night-500 mt-1">{{ __('Davetiyeni yayınladığında katılımcıların yanıtları burada görünecek') }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if (count($invoices) > 0)
            <div class="rounded-2xl bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 shadow-sm animate-fade-in overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold-100 to-gold-200 dark:from-gold-500/20 dark:to-gold-500/10 flex items-center justify-center text-sm">🧾</div>
                        <div>
                            <h3 class="font-bold text-night-900 dark:text-cream-100">{{ __('Fatura Geçmişi') }}</h3>
                            <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Son 10 işlem') }}</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-night-400 dark:text-cream-400 border-b border-cream-100 dark:border-night-700">
                                    <th class="pb-3 font-semibold">{{ __('Fatura No') }}</th>
                                    <th class="pb-3 font-semibold">{{ __('Plan') }}</th>
                                    <th class="pb-3 font-semibold">{{ __('Dönem') }}</th>
                                    <th class="pb-3 font-semibold">{{ __('Tutar') }}</th>
                                    <th class="pb-3 font-semibold">{{ __('Tarih') }}</th>
                                    <th class="pb-3 font-semibold">{{ __('Durum') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $inv)
                                    <tr class="border-b border-cream-50 dark:border-night-800">
                                        <td class="py-3 pr-4">
                                            <a href="{{ route('invoices.show', $inv) }}" class="font-mono text-xs text-indigo-600 dark:text-indigo-400 hover:underline">{{ $inv->invoice_no }}</a>
                                        </td>
                                        <td class="py-3 pr-4 font-semibold text-night-900 dark:text-cream-100">{{ $inv->plan?->name ?? '-' }}</td>
                                        <td class="py-3 pr-4 text-night-500 dark:text-cream-400">{{ $inv->interval === 'yearly' ? __('Yıllık') : __('Aylık') }}</td>
                                        <td class="py-3 pr-4 font-semibold text-night-900 dark:text-cream-100">{{ formatCurrency($inv->amount + $inv->tax_amount) }}</td>
                                        <td class="py-3 pr-4 text-night-500 dark:text-cream-400 whitespace-nowrap">{{ $inv->created_at->format('d.m.Y') }}</td>
                                        <td class="py-3">
                                            @php
                                                $statusText = match(true) {
                                                    $inv->refund_status === 'refunded' => __('İade Edildi'),
                                                    $inv->refund_status === 'requested' => __('İade Talep Edildi'),
                                                    $inv->refund_status === 'rejected' => __('İade Reddedildi'),
                                                    $inv->status === 'paid' => __('Ödendi'),
                                                    default => __('Başarısız'),
                                                };
                                                $statusClass = match(true) {
                                                    $inv->refund_status === 'refunded' => 'bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-500/20',
                                                    $inv->refund_status === 'requested' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
                                                    $inv->refund_status === 'rejected' => 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                                    $inv->status === 'paid' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                                                    default => 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border-red-200 dark:border-red-500/20',
                                                };
                                            @endphp
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-lg border {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

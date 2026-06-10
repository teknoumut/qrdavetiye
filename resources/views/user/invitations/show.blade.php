<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">{{ $invitation->title }}</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">Davetiye istatistikleri</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.invitations.edit', $invitation) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Düzenle
                </a>
                @if($invitation->is_published)
                    <a href="{{ route('user.invitations.rsvps', $invitation) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-night-600 dark:text-cream-300 bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 hover:text-gold-700 dark:hover:text-gold-400 shadow-sm transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        RSVP'ler
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 page-content">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-500/10 dark:to-amber-500/5 flex items-center justify-center text-lg mb-3">👁️</div>
                <div class="text-2xl sm:text-3xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $stats['views'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Görüntülenme</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 50ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-500/10 dark:to-rose-500/5 flex items-center justify-center text-lg mb-3">📱</div>
                <div class="text-2xl sm:text-3xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $stats['qr_scans'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">QR Tarama</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 100ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-500/10 dark:to-emerald-500/5 flex items-center justify-center text-lg mb-3">✅</div>
                <div class="text-2xl sm:text-3xl font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $stats['rsvp_attending'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Katılıyor</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 150ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-500/10 dark:to-violet-500/5 flex items-center justify-center text-lg mb-3">👥</div>
                <div class="text-2xl sm:text-3xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $stats['total_guests'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Toplam Misafir</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 200ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-50 to-red-100 dark:from-red-500/10 dark:to-red-500/5 flex items-center justify-center text-lg mb-3">❌</div>
                <div class="text-2xl sm:text-3xl font-bold text-red-400 dark:text-red-400 tabular-nums">{{ $stats['rsvp_not_attending'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Katılmıyor</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 250ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-500/10 dark:to-amber-500/5 flex items-center justify-center text-lg mb-3">🤔</div>
                <div class="text-2xl sm:text-3xl font-bold text-amber-600 dark:text-amber-400 tabular-nums">{{ $stats['rsvp_maybe'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Belki</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 300ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-500/10 dark:to-pink-500/5 flex items-center justify-center text-lg mb-3">🖼️</div>
                <div class="text-2xl sm:text-3xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $stats['images_count'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Fotoğraflar</div>
            </div>
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 animate-scale-in" style="animation-delay: 350ms">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-500/10 dark:to-blue-500/5 flex items-center justify-center text-lg mb-3">🎬</div>
                <div class="text-2xl sm:text-3xl font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $stats['videos_count'] }}</div>
                <div class="text-xs sm:text-sm text-night-400 dark:text-cream-400 mt-1 font-medium">Videolar</div>
            </div>
        </div>

        @if($invitation->is_published)
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-5 sm:p-6 shadow-sm animate-fade-in">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-50 to-gold-100 dark:from-gold-500/10 dark:to-gold-500/5 flex items-center justify-center text-lg">🔗</div>
                    <div>
                        <h3 class="font-bold text-night-900 dark:text-white">Davetiye Linki</h3>
                        <p class="text-xs text-night-600 dark:text-cream-300">QR kod ve sosyal medyada paylaş</p>
                    </div>
                </div>
                <div class="bg-gold-50/50 dark:bg-gold-500/5 rounded-2xl p-4 border border-gold-100/50 dark:border-gold-500/10 mb-4">
                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="text-sm font-semibold text-gold-700 dark:text-gold-400 break-all hover:text-gold-800 transition-colors">
                        {{ route('invitation.show', $invitation->slug) }}
                    </a>
                </div>

                @php
                    $shareUrl = route('invitation.show', $invitation->slug);
                    $shareText = $invitation->groom_name . ' & ' . $invitation->bride_name . ' - Düğün Davetiyesi';
                    $whatsappUrl = 'https://wa.me/?text=' . urlencode($shareText . ' ' . $shareUrl);
                @endphp
                <div class="flex flex-wrap gap-2.5">
                    <a href="{{ $whatsappUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#128C7E] hover:bg-[#075E54] transition-all duration-300 hover:-translate-y-0.5 shadow-md">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp'ta Paylaş
                    </a>
                    <button onclick="copyLink('{{ $shareUrl }}')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-night-800 dark:text-cream-200 bg-night-100 dark:bg-night-700 hover:bg-night-200 dark:hover:bg-night-600 transition-all duration-300 hover:-translate-y-0.5 border border-night-200 dark:border-night-600 shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Linki Kopyala
                    </button>
                </div>
            </div>
            <script>
                function copyLink(url) {
                    navigator.clipboard.writeText(url).then(function() {
                        var btn = event.target.closest('button');
                        var original = btn.innerHTML;
                        btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Kopyalandı!';
                        setTimeout(function() { btn.innerHTML = original; }, 2000);
                    });
                }
            </script>
        @endif
    </div>
</x-app-layout>

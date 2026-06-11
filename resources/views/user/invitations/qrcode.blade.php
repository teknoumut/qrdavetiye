<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">{{ __('QR Kod') }}</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">{{ $invitation->title }} · {{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
            </div>
            <a href="{{ route('user.invitations.edit', $invitation) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-night-500 dark:text-cream-300 bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Davetiye
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 page-content">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-6 sm:p-8 shadow-sm text-center animate-scale-in">
                @if($qrCode && $qrCode->svg_path)
                    <div class="w-56 h-56 mx-auto mb-6 p-4 bg-white rounded-2xl shadow-sm border border-cream-100 dark:border-night-700">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($qrCode->svg_path) }}" alt="QR Kod" class="w-full h-full">
                    </div>
                    <div class="flex items-center justify-center gap-2 text-sm text-night-400 dark:text-cream-400 mb-6 font-medium bg-cream-50 dark:bg-night-900/50 rounded-xl py-2.5 px-4 border border-cream-100 dark:border-night-700">
                        <span>📱</span>
                        <span>{{ $qrCode->scan_count }} {{ __('kez tarandı') }}</span>
                    </div>
                    <div class="flex justify-center gap-3">
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($qrCode->svg_path) }}" download class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            {{ __('SVG İndir') }}
                        </a>
                        <form action="{{ route('user.invitations.qr-regenerate', $invitation) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-night-500 dark:text-cream-300 bg-white dark:bg-night-900 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">{{ __('Yeniden Oluştur') }}</button>
                        </form>
                    </div>
                @else
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/5 flex items-center justify-center mx-auto mb-5">
                        <span class="text-3xl">📱</span>
                    </div>
                    <p class="text-night-400 dark:text-cream-400 font-medium mb-6">{{ __('QR kod henüz oluşturulmamış.') }}</p>
                    <form action="{{ route('user.invitations.qr-regenerate', $invitation) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-xl text-base font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            {{ __('QR Kod Oluştur') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

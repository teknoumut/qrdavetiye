<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.getItem('dark') === 'true' }" x-init="$watch('dark', val => localStorage.setItem('dark', val))" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-seo />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900|playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Figtree', sans-serif; -webkit-font-smoothing: antialiased; }
            ::selection { background: #d4a61e33; color: #634319; }
            .dark ::selection { background: #d4a61e44; color: #f9edcc; }
            .scrollbar-thin::-webkit-scrollbar { width: 4px; }
            .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
            .scrollbar-thin::-webkit-scrollbar-thumb { background: #d5d9e2; border-radius: 4px; }
            .dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #3d4353; }
        </style>
    </head>
    <body class="bg-cream-50 text-night-900 dark:bg-night-900 dark:text-cream-100 transition-colors duration-300 pt-16">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="sticky top-16 z-40 bg-white/70 dark:bg-night-800/70 backdrop-blur-2xl border-b border-cream-200/50 dark:border-night-700/50 transition-colors duration-300">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-300 text-sm font-medium animate-fade-in">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-800 dark:text-red-300 text-sm font-medium animate-fade-in">
                        {{ session('error') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>

        <footer class="border-t border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-night-400 dark:text-night-500">
                        &copy; {{ date('Y') }} {{ __('senin 💝 davetiyen') }}. {{ __('Tüm hakları saklıdır.') }}
                    </div>
                    <div class="flex flex-wrap justify-center gap-x-5 gap-y-2 text-sm">
                        <a href="{{ route('legal.gizlilik') }}" class="text-night-400 dark:text-night-500 hover:text-gold-500 dark:hover:text-gold-400 no-underline transition-colors">{{ __('Gizlilik Politikası') }}</a>
                        <a href="{{ route('legal.kvkk') }}" class="text-night-400 dark:text-night-500 hover:text-gold-500 dark:hover:text-gold-400 no-underline transition-colors">{{ __('KVKK') }}</a>
                        <a href="{{ route('legal.kullanim') }}" class="text-night-400 dark:text-night-500 hover:text-gold-500 dark:hover:text-gold-400 no-underline transition-colors">{{ __('Kullanım Koşulları') }}</a>
                        <a href="{{ route('legal.iade') }}" class="text-night-400 dark:text-night-500 hover:text-gold-500 dark:hover:text-gold-400 no-underline transition-colors">{{ __('İade Politikası') }}</a>
                        <a href="{{ route('legal.mesafeli') }}" class="text-night-400 dark:text-night-500 hover:text-gold-500 dark:hover:text-gold-400 no-underline transition-colors">{{ __('Mesafeli Satış') }}</a>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            if (localStorage.getItem('dark') === 'true') document.documentElement.classList.add('dark');
        </script>
    </body>
</html>

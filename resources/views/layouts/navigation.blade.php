@auth
<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" :class="scrolled ? 'bg-white/90 dark:bg-night-800/90 backdrop-blur-2xl shadow-sm dark:shadow-night-900/50' : 'bg-white/70 dark:bg-night-800/70 backdrop-blur-xl'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-br from-gold-400 to-rose-500 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 group-hover:shadow-gold-300/60 dark:group-hover:shadow-gold-400/30 transition-all duration-300 group-hover:scale-110">s</span>
                <span class="font-bold text-base sm:text-lg tracking-tight text-night-900 dark:text-cream-100 hidden sm:block">senin 💝 davetiyen</span>
            </a>

            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('reviews.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('reviews*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-500 dark:text-night-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                    {{ __('Yorumlar') }}
                </a>
                <a href="{{ route('user.rsvps.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('user.rsvps*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-500 dark:text-night-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                    {{ __("RSVP'lerim") }}
                </a>
                <a href="{{ route('user.invitations.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('user.invitations*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-500 dark:text-night-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                    {{ __('Davetiyelerim') }}
                </a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-500 dark:text-night-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                        {{ __('Admin Panel') }}
                    </a>
                @endif

            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <button @click="dark = !dark" class="w-9 h-9 rounded-xl flex items-center justify-center text-night-400 dark:text-cream-300 hover:bg-gold-50 dark:hover:bg-gold-500/10 transition-all duration-200" title="{{ __('Tema değiştir') }}">
                    <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 sm:gap-2.5 px-3 sm:px-4 py-2 rounded-xl text-sm font-medium text-night-600 dark:text-cream-200 bg-gold-50/50 dark:bg-gold-500/5 hover:bg-gold-50 dark:hover:bg-gold-500/10 border border-gold-200/50 dark:border-gold-500/10 hover:border-gold-300 dark:hover:border-gold-500/20 transition-all duration-200">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white shadow-sm overflow-hidden">
                            @if(Auth::user()->photo_url)
                                <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="w-full h-full bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center">{{ Auth::user()->initial }}</span>
                            @endif
                        </span>
                        <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-night-400 dark:text-cream-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 mt-2 w-56 bg-white dark:bg-night-800 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_40px_rgba(0,0,0,0.3)] border border-cream-200 dark:border-night-700 py-2 overflow-hidden">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-night-600 dark:text-cream-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5 transition-colors">
                            <svg class="w-4 h-4 text-night-400 dark:text-cream-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Ayarlar') }}
                        </a>
                        <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-night-600 dark:text-cream-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5 transition-colors">
                            <svg class="w-4 h-4 text-night-400 dark:text-cream-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.5.835 2.5 1.875M11 17.25c0-.621.504-1.125 1.125-1.125h.75c.621 0 1.125.504 1.125 1.125v.75c0 .621-.504 1.125-1.125 1.125h-.75c-.621 0-1.125-.504-1.125-1.125v-.75z"/></svg>
                            {{ __('Profilim') }}
                        </a>
                        <hr class="my-1 border-cream-200 dark:border-night-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/5 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Çıkış Yap') }}
                            </button>
                        </form>
                    </div>
                </div>

                <button @click="open = !open" class="md:hidden w-9 h-9 rounded-xl flex items-center justify-center text-night-500 dark:text-cream-300 hover:bg-gold-50 dark:hover:bg-gold-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden border-t border-cream-200 dark:border-night-700 bg-white/95 dark:bg-night-800/95 backdrop-blur-2xl shadow-lg">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('reviews.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('reviews*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-600 dark:text-cream-300 hover:text-gold-700 dark:hover:text-gold-400 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                {{ __('Yorumlar') }}
            </a>
            <a href="{{ route('user.rsvps.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('user.rsvps*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-600 dark:text-cream-300 hover:text-gold-700 dark:hover:text-gold-400 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                {{ __("RSVP'lerim") }}
            </a>
            <a href="{{ route('user.invitations.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('user.invitations*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-600 dark:text-cream-300 hover:text-gold-700 dark:hover:text-gold-400 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                {{ __('Davetiyelerim') }}
            </a>
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.*') ? 'text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 font-semibold' : 'text-night-600 dark:text-cream-300 hover:text-gold-700 dark:hover:text-gold-400 hover:bg-gold-50 dark:hover:bg-gold-500/5' }}">
                    {{ __('Admin Panel') }}
                </a>
            @endif
        </div>
        <div class="border-t border-cream-200 dark:border-night-700 px-4 py-3">
            <div class="flex items-center gap-3 px-4 mb-3">
                <span class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold text-white shadow-sm overflow-hidden">
                    @if(Auth::user()->photo_url)
                        <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="w-full h-full bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center">{{ Auth::user()->initial }}</span>
                    @endif
                </span>
                <div>
                    <div class="text-sm font-semibold text-night-900 dark:text-cream-100">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-night-400 dark:text-cream-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="space-y-1">
                <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-night-600 dark:text-cream-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.5.835 2.5 1.875M11 17.25c0-.621.504-1.125 1.125-1.125h.75c.621 0 1.125.504 1.125 1.125v.75c0 .621-.504 1.125-1.125 1.125h-.75c-.621 0-1.125-.504-1.125-1.125v-.75z"/></svg>
                    {{ __('Profilim') }}
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-night-600 dark:text-cream-300 hover:text-night-900 dark:hover:text-cream-100 hover:bg-gold-50 dark:hover:bg-gold-500/5 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ __('Ayarlar') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/5 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        {{ __('Çıkış Yap') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
@else
<div class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-night-800/80 backdrop-blur-xl border-b border-cream-200 dark:border-night-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
            <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-br from-gold-400 to-rose-500 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-gold-200/50">s</span>
            <span class="font-bold text-base sm:text-lg tracking-tight text-night-900 dark:text-cream-100 hidden sm:block">senin 💝 davetiyen</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-night-600 dark:text-cream-300 hover:text-night-900 dark:hover:text-cream-100 transition-colors">Giriş Yap</a>
            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-gold-400 to-rose-500 hover:opacity-90 transition-all shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20">Kayıt Ol</a>
        </div>
    </div>
</div>
@endauth

<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-white font-bold text-lg">senin 💝 davetiyen Admin</a>
                </div>
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.users*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Kullanıcılar
                    </a>
                    <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.plans*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Paketler
                    </a>
                    <a href="{{ route('admin.themes.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.themes*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Temalar
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.reviews*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Yorumlar
                    </a>
                    <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.contact-messages*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Mesajlar
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white {{ request()->routeIs('admin.settings*') ? 'text-white border-b-2 border-indigo-400' : '' }}">
                        Ayarlar
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white text-sm">Çıkış</button>
                </form>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Kullanıcılar</a>
            <a href="{{ route('admin.plans.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Paketler</a>
            <a href="{{ route('admin.themes.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Temalar</a>
            <a href="{{ route('admin.reviews.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Yorumlar</a>
            <a href="{{ route('admin.contact-messages.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Mesajlar</a>
            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white">Ayarlar</a>
        </div>
    </div>
</nav>

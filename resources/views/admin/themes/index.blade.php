<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                Tema Yönetimi
                <span class="sub">Davetiye temalarını görüntüleyin ve yönetin</span>
            </div>
            <a href="{{ route('admin.themes.create') }}" class="btn-primary">+ Yeni Tema</a>
        </div>
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($themes as $theme)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="h-36 relative" style="background: linear-gradient(135deg, {{ $theme->primary_color }}, {{ $theme->secondary_color }});">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute bottom-3 left-4">
                        <span class="text-white text-xs font-semibold bg-black/30 px-2.5 py-1 rounded-lg backdrop-blur-sm">{{ $theme->name }}</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $theme->name }}</h3>
                    <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $theme->description }}</p>
                    <div class="flex items-center mt-3 gap-2 flex-wrap">
                        @if($theme->is_premium)
                            <span class="text-[10px] font-semibold bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded-full border border-yellow-200">Premium</span>
                        @endif
                        @if($theme->is_active)
                            <span class="text-[10px] font-semibold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full border border-emerald-200">Aktif</span>
                        @endif
                    </div>
                    <div class="flex mt-4 gap-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('admin.themes.edit', $theme) }}" class="flex-1 text-center btn-ghost text-xs py-2">Düzenle</a>
                        <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" class="flex-1" onsubmit="return confirm('Emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-center btn-ghost text-xs py-2 text-red-600 border-red-200 hover:bg-red-50">Sil</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-admin-layout>

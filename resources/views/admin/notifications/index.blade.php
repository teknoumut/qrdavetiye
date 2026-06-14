<x-admin-layout>
    <x-slot name="header">
        Bildirimler
        <span class="sub">Tüm bekleyen işlemler</span>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Toplam Bildirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['payments'] }}</div>
            <div class="stat-label">💳 Ödeme</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['reviews'] }}</div>
            <div class="stat-label">💬 Yorum</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['messages'] + $stats['refunds'] }}</div>
            <div class="stat-label">✉️ Mesaj & 🔄 İade</div>
        </div>
    </div>

    @if($notifications->isEmpty())
        <div class="glass-card p-12 text-center">
            <div class="text-4xl mb-3">✅</div>
            <div class="text-gray-400 font-medium">Hiç bildirim yok, her şey yolunda!</div>
        </div>
    @else
        <div class="glass-card overflow-hidden">
            <div class="divide-y divide-gray-100">
                @foreach($notifications as $n)
                    <a href="{{ $n['url'] }}" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-all group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg shrink-0
                            @switch($n['type'])
                                @case('payment') bg-amber-50 @break
                                @case('review') bg-blue-50 @break
                                @case('message') bg-purple-50 @break
                                @case('refund') bg-red-50 @break
                            @endswitch
                        ">{{ $n['icon'] }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-sm text-gray-900">{{ $n['title'] }}</div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">{{ $n['description'] }}</div>
                        </div>
                        <div class="text-xs text-gray-400 shrink-0">{{ $n['time']->diffForHumans() }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</x-admin-layout>

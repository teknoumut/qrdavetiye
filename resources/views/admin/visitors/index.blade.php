<x-admin-layout>
    <x-slot name="header">
        Ziyaretçiler
        <span class="sub">Siteyi ziyaret eden IP'ler ve konum bilgileri</span>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div class="text-sm text-gray-500">Sadece ana sayfa ziyaretleri sayılır. Admin girişleri dahil edilmez.</div>
        <form method="POST" action="{{ route('admin.visitors.reset') }}" onsubmit="return confirm('Tüm ziyaretçi kayıtları silinecek! Emin misiniz?')">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-50 border border-red-200 text-red-600 hover:bg-red-100 text-sm font-semibold transition-all flex items-center gap-2">
                🗑️ Ziyaretçi Kayıtlarını Sıfırla
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card">
            <div class="stat-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-label">Toplam Ziyaret</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($stats['unique_ips']) }}</div>
            <div class="stat-label">Tekil IP</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['today'] }}</div>
            <div class="stat-label">Bugün</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['countries'] }}</div>
            <div class="stat-label">Ülke</div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="table-wrap">
                    <table>
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Konum</th>
                        <th>ISS</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $visit)
                        <tr>
                            <td><span class="font-mono text-xs">{{ $visit->ip }}</span></td>
                            <td>
                                @php
                                    $parts = [];
                                    if ($visit->city) $parts[] = $visit->city;
                                    if ($visit->country) $parts[] = $visit->country;
                                    $location = implode(', ', $parts);
                                @endphp
                                @if($location)
                                    <span title="{{ $location }}">{{ $location }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="text-xs text-gray-500">{{ $visit->isp ?? '-' }}</td>
                            <td class="whitespace-nowrap text-xs text-gray-500">{{ $visit->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-400">Henüz ziyaretçi kaydı yok</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($visits->hasPages())
            <div class="px-6 py-3 border-t border-gray-100">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

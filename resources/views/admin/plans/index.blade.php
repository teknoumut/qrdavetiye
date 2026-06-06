<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                Paket Yönetimi
                <span class="sub">Üyelik paketlerini ve fiyatlandırmayı yönetin</span>
            </div>
            <a href="{{ route('admin.plans.create') }}" class="btn-primary">+ Yeni Paket</a>
        </div>
    </x-slot>
    <div class="glass-card overflow-hidden">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:30%">Paket</th>
                        <th style="width:12%">Aylık</th>
                        <th style="width:12%">Yıllık</th>
                        <th style="width:10%">Davetiye</th>
                        <th style="width:10%">Durum</th>
                        <th style="width:28%" class="text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3" style="white-space:nowrap">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm shrink-0" style="background:#eef2ff;color:#4f46e5">📦</div>
                                <div style="overflow:hidden;text-overflow:ellipsis">
                                    <div class="font-medium" style="overflow:hidden;text-overflow:ellipsis">{{ $plan->name }}</div>
                                    <div class="text-xs text-gray-400" style="overflow:hidden;text-overflow:ellipsis">{{ Str::limit($plan->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="font-medium" style="white-space:nowrap">{{ number_format($plan->monthly_price, 2) }} TL</td>
                        <td class="font-medium" style="white-space:nowrap">{{ number_format($plan->yearly_price, 2) }} TL</td>
                        <td style="white-space:nowrap">{{ $plan->max_invitations }} adet</td>
                        <td>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg {{ $plan->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}" style="white-space:nowrap">
                                <span class="w-1.5 h-1.5 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                {{ $plan->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1" style="white-space:nowrap">
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="btn-ghost text-xs px-2 py-1.5">Düzenle</a>
                                <form action="{{ route('admin.plans.toggle-active', $plan) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-ghost text-xs px-2 py-1.5 {{ $plan->is_active ? 'text-red-600 border-red-200 hover:bg-red-50' : 'text-emerald-600 border-emerald-200 hover:bg-emerald-50' }}">
                                        {{ $plan->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Emin misiniz?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-ghost text-xs px-2 py-1.5 text-red-600 border-red-200 hover:bg-red-50">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

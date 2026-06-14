<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-night-900 dark:text-cream-100">Tüm Ödemeler</h1>
            <p class="text-sm text-night-400 dark:text-night-500 mt-1">Kartlı ve EFT/Havale ödemelerini görüntüleyin.</p>
        </div>
        <form method="POST" action="{{ route('admin.payment-notifications.reset-revenue') }}" onsubmit="return confirm('Tüm ödeme kayıtları ve faturalar silinecek! Gelir sıfırlanacak! Emin misiniz?')">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 text-sm font-semibold transition-all flex items-center gap-2">
                🗑️ Gelir Kayıtlarını Sıfırla
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-300 text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-800 dark:text-red-300 text-sm font-medium">{{ session('error') }}</div>
    @endif

    <div x-data="{ tab: 'eft' }">
        <div class="flex gap-1 mb-5 p-1 bg-night-50 dark:bg-night-800 rounded-xl w-fit">
            <button @click="tab = 'eft'"
                class="px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200"
                :class="tab === 'eft' ? 'bg-white dark:bg-night-700 text-night-900 dark:text-cream-100 shadow-sm' : 'text-night-400 dark:text-night-500 hover:text-night-600 dark:hover:text-night-300'">
                EFT/Havale Bildirimleri
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold rounded-full"
                    :class="tab === 'eft' ? 'bg-red-100 text-red-600' : 'bg-night-200 dark:bg-night-600 text-night-400'">
                    {{ $notifications->total() }}
                </span>
            </button>
            <button @click="tab = 'invoice'"
                class="px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200"
                :class="tab === 'invoice' ? 'bg-white dark:bg-night-700 text-night-900 dark:text-cream-100 shadow-sm' : 'text-night-400 dark:text-night-500 hover:text-night-600 dark:hover:text-night-300'">
                Kartlı Ödemeler
                <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold rounded-full"
                    :class="tab === 'invoice' ? 'bg-blue-100 text-blue-600' : 'bg-night-200 dark:bg-night-600 text-night-400'">
                    {{ $invoices->total() }}
                </span>
            </button>
        </div>

        <div x-show="tab === 'eft'">
            <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-night-50 dark:bg-night-700/50 border-b border-cream-200 dark:border-night-700">
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Tarih</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Kullanıcı</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Sipariş No</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Plan</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Tutar</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Durum</th>
                                <th class="text-right py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cream-200 dark:divide-night-700">
                            @forelse ($notifications as $n)
                                <tr class="hover:bg-night-50 dark:hover:bg-night-700/30 transition-colors">
                                    <td class="py-3.5 px-4 text-night-500 dark:text-night-400 whitespace-nowrap">{{ $n->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center text-xs font-bold text-white shrink-0">{{ substr($n->user->name, 0, 1) }}</span>
                                            <div>
                                                <div class="font-semibold text-night-900 dark:text-cream-100">{{ $n->user->name }}</div>
                                                <div class="text-xs text-night-400">{{ $n->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-sm font-bold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ $n->order_no }}</td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="font-semibold text-night-900 dark:text-cream-100">{{ $n->plan->name }}</span>
                                        <span class="text-xs text-night-400">/ {{ $n->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</span>
                                        @if($n->is_upgrade)<span class="ml-1.5 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300">YÜKSELTME</span>@endif
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ number_format($n->amount, 2) }} TL</td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        @if($n->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Bekliyor
                                            </span>
                                        @elseif($n->status === 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Onaylandı
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Reddedildi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        @if($n->status === 'pending')
                                            <div class="flex items-center justify-end gap-2">
                                                <form method="POST" action="{{ route('admin.payment-notifications.approve', $n) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold transition-colors" onclick="return confirm('Aboneliği aktifleştirilsin mi?')">Onayla</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.payment-notifications.reject', $n) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-500/30 text-xs font-semibold transition-colors" onclick="return confirm('Reddetmek istediğinize emin misiniz?')">Reddet</button>
                                                </form>
                                            </div>
                                        @elseif($n->status === 'approved')
                                            <span class="text-xs text-night-400">{{ $n->approved_at?->format('d.m.Y H:i') }}</span>
                                        @elseif($n->status === 'rejected')
                                            <span class="text-xs text-night-400">{{ $n->approved_at?->format('d.m.Y H:i') }}</span>
                                        @endif
                                        <form method="POST" action="{{ route('admin.payment-notifications.destroy', $n) }}" class="inline" onsubmit="return confirm('Bu ödeme kaydını silmek istediğinize emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 rounded text-xs font-semibold text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors" title="Sil">🗑️</button>
                                        </form>
                                        @if($n->notes)
                                            <div class="text-xs text-night-400 mt-1 max-w-[200px] truncate" title="{{ $n->notes }}">📝 {{ $n->notes }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="text-night-300 dark:text-night-500">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            <p class="text-sm font-medium">Henüz EFT/Havale bildirimi bulunmuyor.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>

        <div x-show="tab === 'invoice'" x-cloak>
            <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-night-50 dark:bg-night-700/50 border-b border-cream-200 dark:border-night-700">
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Tarih</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Kullanıcı</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Fatura No</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Plan</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Tutar</th>
                                <th class="text-left py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Ödeme</th>
                                <th class="text-right py-3.5 px-4 font-semibold text-night-400 dark:text-night-500 text-xs uppercase tracking-wider">Fatura</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cream-200 dark:divide-night-700">
                            @forelse ($invoices as $inv)
                                <tr class="hover:bg-night-50 dark:hover:bg-night-700/30 transition-colors">
                                    <td class="py-3.5 px-4 text-night-500 dark:text-night-400 whitespace-nowrap">{{ $inv->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-xs font-bold text-white shrink-0">{{ substr($inv->user->name, 0, 1) }}</span>
                                            <div>
                                                <div class="font-semibold text-night-900 dark:text-cream-100">{{ $inv->user->name }}</div>
                                                <div class="text-xs text-night-400">{{ $inv->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-sm font-bold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ $inv->invoice_no }}</td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="font-semibold text-night-900 dark:text-cream-100">{{ $inv->plan->name }}</span>
                                        <span class="text-xs text-night-400">/ {{ $inv->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ number_format($inv->amount, 2) }} TL</td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Ödendi
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('invoices.show', $inv) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-xs font-semibold transition-colors" target="_blank">
                                                Görüntüle
                                            </a>
                                            <a href="{{ route('invoices.download', $inv) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 text-xs font-semibold transition-colors">
                                                İndir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="text-night-300 dark:text-night-500">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <p class="text-sm font-medium">Henüz kartlı ödeme bulunmuyor.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
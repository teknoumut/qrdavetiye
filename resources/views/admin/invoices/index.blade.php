<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-night-900 dark:text-cream-100">Tüm Faturalar</h1>
            <p class="text-sm text-night-400 dark:text-night-500 mt-1">Tüm ödeme faturalarını görüntüleyin.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <span class="text-xs text-night-400 dark:text-night-500">Toplam Gelir</span>
                <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($totalRevenue, 2) }} TL</div>
            </div>
            <div class="text-right">
                <span class="text-xs text-night-400 dark:text-night-500">Toplam KDV</span>
                <div class="text-lg font-bold text-night-600 dark:text-cream-300">{{ number_format($totalTax, 2) }} TL</div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-300 text-sm font-medium">{{ session('success') }}</div>
    @endif

    <div class="bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-night-50 dark:bg-night-700/50 border-b border-cream-200 dark:border-night-700">
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Tarih</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Kullanici</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Fatura No</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Plan</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Tutar</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">KDV</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Odeme</th>
                        <th class="text-left py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Durum</th>
                        <th class="text-right py-3.5 px-4 font-semibold text-night-400 text-xs uppercase">Islem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200 dark:divide-night-700">
                    @forelse ($invoices as $inv)
                        <tr class="hover:bg-night-50 dark:hover:bg-night-700/30 transition-colors">
                            <td class="py-3.5 px-4 text-night-500 whitespace-nowrap">{{ $inv->created_at->format('d.m.Y H:i') }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center text-xs font-bold text-white shrink-0">{{ substr($inv->user->name, 0, 1) }}</span>
                                    <div>
                                        <div class="font-semibold text-night-900 dark:text-cream-100">{{ $inv->user->name }}</div>
                                        <div class="text-xs text-night-400">{{ $inv->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-sm font-bold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ $inv->invoice_no }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-semibold text-night-900 dark:text-cream-100">{{ $inv->plan->name ?? '-' }}</span>
                                <span class="text-xs text-night-400">/ {{ $inv->interval === 'yearly' ? 'Yillik' : 'Aylik' }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-night-900 dark:text-cream-100 whitespace-nowrap">{{ number_format($inv->amount, 2) }} TL</td>
                            <td class="py-3.5 px-4 text-night-500 whitespace-nowrap">{{ number_format($inv->tax_amount, 2) }} TL</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-medium text-night-500">{{ $inv->gateway }}</span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($inv->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">Odendi</span>
                                @elseif($inv->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 text-xs font-semibold">Bekliyor</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 text-xs font-semibold">{{ ucfirst($inv->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('invoices.show', $inv) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-xs font-semibold transition-colors" target="_blank">
                                        Goruntule
                                    </a>
                                    <a href="{{ route('invoices.download', $inv) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 text-xs font-semibold transition-colors">
                                        Indir
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12">
                                <div class="text-night-300 dark:text-night-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-sm font-medium">Henuz fatura bulunmuyor.</p>
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
</x-admin-layout>

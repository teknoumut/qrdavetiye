<x-admin-layout>
    <x-slot name="header">
        İade Talepleri
        <span class="sub">İade taleplerini yönetin</span>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#fef2f2;color:#dc2626">🔄</span>
                    Bekleyen İade Talepleri
                    <span class="inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $requests->total() }}</span>
                </h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($requests as $invoice)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $invoice->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $invoice->user->email }}</div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700">
                                {{ $invoice->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                            <span>{{ $invoice->plan->name }}</span>
                            <span>•</span>
                            <span>{{ $invoice->interval === 'yearly' ? 'Yıllık' : 'Aylık' }}</span>
                            <span>•</span>
                            <span>{{ number_format($invoice->amount + $invoice->tax_amount, 2) }} TL</span>
                        </div>
                        @if($invoice->refund_reason)
                            <div class="text-xs text-gray-500 bg-gray-50 rounded-lg px-3 py-2 mb-3">
                                <span class="font-medium text-gray-700">Sebep:</span> {{ $invoice->refund_reason }}
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.refund-requests.approve', $invoice) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition-all border border-emerald-200">
                                    ✅ İadeyi Onayla
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.refund-requests.reject', $invoice) }}" onsubmit="return confirm('İade talebini reddetmek istediğinize emin misiniz?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-semibold hover:bg-red-100 transition-all border border-red-200">
                                    ❌ Reddet
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">Bekleyen iade talebi yok</div>
                @endforelse
            </div>
            @if($requests->hasPages())
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>

        <div class="glass-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#ecfdf5;color:#059669">✅</span>
                    Onaylanan İadeler
                </h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($refunded as $invoice)
                    <div class="px-6 py-3.5">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $invoice->user->name }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $invoice->plan->name }} • {{ number_format($invoice->amount + $invoice->tax_amount, 2) }} TL
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-xs text-gray-500">{{ $invoice->refunded_at?->format('d.m.Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $invoice->refundApprover?->name }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">Henüz onaylanan iade yok</div>
                @endforelse
            </div>
            @if($refunded->hasPages())
                <div class="px-6 py-3 border-t border-gray-100">
                    {{ $refunded->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

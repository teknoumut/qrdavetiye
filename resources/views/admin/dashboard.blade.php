<x-admin-layout>
    <x-slot name="header">
        Dashboard
        <span class="sub">Genel sistem özeti ve istatistikler</span>
    </x-slot>

    @if($expired > 0 || $expiring_soon > 0)
        <div class="flex flex-wrap gap-3 mb-6">
            @if($expired > 0)
                <div class="flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    {{ $expired }} kullanıcının süresi doldu (pasif yapılmayı bekliyor)
                </div>
            @endif
            @if($expiring_soon > 0)
                <div class="flex items-center gap-2.5 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                    {{ $expiring_soon }} kullanıcının süresi yakında doluyor
                </div>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#eef2ff;color:#4f46e5">👥</div>
                <span class="badge" style="background:#eef2ff;color:#4f46e5">{{ $active_users }} aktif</span>
            </div>
            <div class="stat-value">{{ $total_users }}</div>
            <div class="stat-label">Toplam Kullanıcı</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_users > 0 ? ($active_users/$total_users)*100 : 0 }}%;background:linear-gradient(90deg,#4f46e5,#818cf8)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#ecfdf5;color:#059669">📋</div>
                <span class="badge" style="background:#f8fafc;color:#94a3b8">{{ $passive_users }} pasif</span>
            </div>
            <div class="stat-value">{{ $total_invitations }}</div>
            <div class="stat-label">Toplam Davetiye</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_invitations > 0 ? min(($total_invitations/50)*100,100) : 0 }}%;background:linear-gradient(90deg,#059669,#34d399)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#fff7ed;color:#d97706">👁️</div>
                <span class="badge" style="background:#f8fafc;color:#94a3b8">{{ $total_invitations > 0 ? round($total_views / $total_invitations, 1) : 0 }} ort.</span>
            </div>
            <div class="stat-value">{{ $total_views }}</div>
            <div class="stat-label">Toplam Görüntülenme</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_views > 0 ? min(($total_views/1000)*100,100) : 0 }}%;background:linear-gradient(90deg,#d97706,#fbbf24)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#fdf2f8;color:#db2777">💌</div>
                <span class="badge" style="background:#f8fafc;color:#94a3b8">{{ $total_rsvps }} RSVP</span>
            </div>
            <div class="stat-value">{{ $total_qr_scans }}</div>
            <div class="stat-label">QR Tarama</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_qr_scans > 0 ? min(($total_qr_scans/500)*100,100) : 0 }}%;background:linear-gradient(90deg,#db2777,#f472b6)"></div></div>
        </div>
    </div>

    @php
        $allPayments = collect()
            ->merge($recent_invoices->map(function($i) {
                return (object)[
                    'type' => 'online',
                    'user' => $i->user,
                    'plan' => $i->plan,
                    'amount' => $i->amount,
                    'interval' => $i->interval,
                    'date' => $i->created_at,
                    'label' => 'Kart',
                    'status' => 'paid',
                    'invoice_no' => $i->invoice_no,
                ];
            }))
            ->merge($recent_approved_payments->map(function($p) {
                return (object)[
                    'type' => 'eft',
                    'user' => $p->user,
                    'plan' => $p->plan,
                    'amount' => $p->amount,
                    'interval' => $p->interval,
                    'date' => $p->approved_at ?: $p->created_at,
                    'label' => 'EFT/Havale',
                    'status' => 'approved',
                    'order_no' => $p->order_no,
                ];
            }))
            ->sortByDesc('date')
            ->take(10);
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#fef2f2;color:#dc2626">💳</div>
                <span class="badge" style="background:#fef2f2;color:#dc2626">{{ $pending_payments }} bekleyen</span>
            </div>
            <div class="stat-value">{{ number_format($total_revenue, 0) }} TL</div>
            <div class="stat-label">Toplam Gelir</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_revenue > 0 ? min(($total_revenue/50000)*100,100) : 0 }}%;background:linear-gradient(90deg,#dc2626,#f87171)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#eef2ff;color:#4f46e5">👥</div>
                <span class="badge" style="background:#eef2ff;color:#4f46e5">{{ $active_users }} aktif</span>
            </div>
            <div class="stat-value">{{ $total_users }}</div>
            <div class="stat-label">Toplam Kullanıcı</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_users > 0 ? ($active_users/$total_users)*100 : 0 }}%;background:linear-gradient(90deg,#4f46e5,#818cf8)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#ecfdf5;color:#059669">📋</div>
                <span class="badge" style="background:#f8fafc;color:#94a3b8">{{ $passive_users }} pasif</span>
            </div>
            <div class="stat-value">{{ $total_invitations }}</div>
            <div class="stat-label">Toplam Davetiye</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_invitations > 0 ? min(($total_invitations/50)*100,100) : 0 }}%;background:linear-gradient(90deg,#059669,#34d399)"></div></div>
        </div>
        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon" style="background:#fdf2f8;color:#db2777">👁️</div>
                <span class="badge" style="background:#f8fafc;color:#94a3b8">{{ $total_invitations > 0 ? round($total_views / $total_invitations, 1) : 0 }} ort.</span>
            </div>
            <div class="stat-value">{{ $total_views }}</div>
            <div class="stat-label">Toplam Görüntülenme</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $total_views > 0 ? min(($total_views/1000)*100,100) : 0 }}%;background:linear-gradient(90deg,#db2777,#f472b6)"></div></div>
        </div>
    </div>

    @if($pending_payments > 0 || $allPayments->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            @if($pending_payments > 0)
                <div class="glass-card overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#fef2f2;color:#dc2626">💳</span>
                            Bekleyen Ödemeler
                            <span class="inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $pending_payments }}</span>
                        </h3>
                        <a href="{{ route('admin.payment-notifications.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümünü Gör →</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recent_payments as $p)
                            <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-amber-500 flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0">
                                        {{ strtoupper(substr($p->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $p->user->name }}</div>
                                        <div class="text-xs text-gray-400 truncate">{{ $p->plan->name }} • {{ $p->interval === 'yearly' ? 'Yıllık' : 'Aylık' }} • {{ number_format($p->amount, 2) }} TL</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        {{ $p->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-gray-400 text-sm">Bekleyen ödeme yok</div>
                        @endforelse
                    </div>
                </div>
            @endif
            <div class="glass-card overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#ecfdf5;color:#059669">✅</span>
                        Son Ödemeler
                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-700">{{ $allPayments->count() }}</span>
                    </h3>
                    <a href="{{ route('admin.payment-notifications.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tüm Ödemeler →</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($allPayments as $p)
                        <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0">
                                    {{ strtoupper(substr($p->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-gray-900 truncate">{{ $p->user->name }}</div>
                                    <div class="text-xs text-gray-400 truncate">
                                        {{ $p->plan->name }} • {{ $p->interval === 'yearly' ? 'Yıllık' : 'Aylık' }} • {{ number_format($p->amount, 2) }} TL
                                        <span class="ml-1.5 inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $p->type === 'online' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                            {{ $p->label }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-50 text-gray-500 shrink-0">
                                {{ $p->date->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-gray-400 text-sm">Henüz ödeme yok</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#eef2ff;color:#4f46e5">👤</span>
                    Son Kullanıcılar
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümünü Gör →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recent_users as $user)
                    <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if($user->subscription_end)
                                <span class="text-xs {{ $user->subscription_end->isPast() ? 'text-red-500' : ($user->isExpiringSoon() ? 'text-yellow-500' : 'text-gray-400') }}">
                                    {{ $user->subscription_end->format('d.m.Y') }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">Henüz kullanıcı yok</div>
                @endforelse
            </div>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-sm text-gray-900 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs" style="background:#ecfdf5;color:#059669">💌</span>
                    Son Davetiyeler
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümünü Gör →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recent_invitations as $inv)
                    <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $inv->title }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $inv->user->name }} • {{ $inv->views }} görüntülenme</div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg shrink-0 {{ $inv->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $inv->is_published ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                            {{ $inv->is_published ? 'Yayında' : 'Taslak' }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-400 text-sm">Henüz davetiye yok</div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">
        RSVP Kayıtları
        <span class="sub">Tüm davetiyelere ait katılım yanıtları</span>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-label">Toplam RSVP</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-emerald-600">{{ $attending }}</div>
            <div class="stat-label">Katılımcı Sayısı</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-red-500">{{ $notAttending }}</div>
            <div class="stat-label">Katılamıyor</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-amber-500">{{ $maybe }}</div>
            <div class="stat-label">Belki</div>
        </div>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-5">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" placeholder="İsim, e-posta, telefon veya davetiye ara..." value="{{ request('search') }}" class="w-full">
        </div>
        <select name="status" class="w-auto min-w-[140px]">
            <option value="">Tümü</option>
            <option value="attending" {{ request('status') === 'attending' ? 'selected' : '' }}>Katılıyor</option>
            <option value="not_attending" {{ request('status') === 'not_attending' ? 'selected' : '' }}>Katılamıyor</option>
            <option value="maybe" {{ request('status') === 'maybe' ? 'selected' : '' }}>Belki</option>
        </select>
        <button type="submit" class="btn-primary">Filtrele</button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.rsvps.index') }}" class="btn-ghost">Sıfırla</a>
        @endif
    </form>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>İsim</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Durum</th>
                        <th>Kişi</th>
                        <th>Davetiye</th>
                        <th>Kullanıcı</th>
                        <th>Mesaj</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rsvps as $rsvp)
                        <tr>
                            <td class="font-medium">{{ $rsvp->name }}</td>
                            <td>{{ $rsvp->email ?? '-' }}</td>
                            <td>{{ $rsvp->phone ?? '-' }}</td>
                            <td>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                    @if($rsvp->status === 'attending') bg-emerald-50 text-emerald-700
                                    @elseif($rsvp->status === 'not_attending') bg-red-50 text-red-500
                                    @else bg-amber-50 text-amber-600 @endif">
                                    @if($rsvp->status === 'attending') Katılıyor
                                    @elseif($rsvp->status === 'not_attending') Katılamıyor
                                    @else Belki @endif
                                </span>
                            </td>
                            <td class="font-bold tabular-nums">{{ $rsvp->guest_count }}</td>
                            <td>
                                @if($rsvp->invitation)
                                    {{ $rsvp->invitation->title }}
                                @else
                                    <span class="text-gray-400">Silinmiş</span>
                                @endif
                            </td>
                            <td>
                                @if($rsvp->invitation && $rsvp->invitation->user)
                                    <a href="{{ route('admin.users.edit', $rsvp->invitation->user) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        {{ $rsvp->invitation->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="max-w-[180px] truncate" title="{{ $rsvp->message ?? '' }}">{{ $rsvp->message ?? '-' }}</td>
                            <td class="text-gray-400 whitespace-nowrap">{{ $rsvp->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-gray-400 py-12">RSVP kaydı bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rsvps->hasPages())
            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">{{ $rsvps->links() }}</div>
        @endif
    </div>
</x-admin-layout>

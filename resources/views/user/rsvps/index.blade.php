<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">RSVP Kayıtlarım</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">Tüm davetiyelerine gelen katılım yanıtları</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 page-content">
        <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl shadow-sm overflow-hidden animate-fade-in">
            @if($rsvps->count() === 0)
                <div class="text-center py-20">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/5 flex items-center justify-center mx-auto mb-5">
                        <span class="text-3xl">💌</span>
                    </div>
                    <p class="text-night-400 dark:text-cream-400 text-sm font-medium">Henüz RSVP kaydı bulunmuyor.</p>
                    <p class="text-xs text-night-300 dark:text-night-500 mt-1">Davetiyeni yayınladığında katılımcıların yanıtları burada listelenecek</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/5 dark:to-rose-500/5 border-b border-cream-100 dark:border-night-700">
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Ad</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">E-posta</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Telefon</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Durum</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Kişi</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Davetiye</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Mesaj</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Tarih</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider">Onay</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cream-50 dark:divide-night-700/50">
                            @foreach($rsvps as $rsvp)
                            <tr class="hover:bg-cream-50/50 dark:hover:bg-gold-500/5 transition-colors {{ !$rsvp->is_confirmed ? 'bg-amber-50/30 dark:bg-amber-500/5' : '' }}">
                                <td class="px-6 py-4 text-sm font-semibold text-night-900 dark:text-cream-100">{{ $rsvp->name }}</td>
                                <td class="px-6 py-4 text-sm text-night-400 dark:text-cream-400">{{ $rsvp->email ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-night-400 dark:text-cream-400">{{ $rsvp->phone ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex text-xs font-bold px-3 py-1.5 rounded-full
                                        @if($rsvp->status === 'attending') bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20
                                        @elseif($rsvp->status === 'not_attending') bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 border border-red-200 dark:border-red-500/20
                                        @else bg-gold-50 dark:bg-gold-500/10 text-gold-700 dark:text-gold-400 border border-gold-200 dark:border-gold-500/20 @endif">
                                        @if($rsvp->status === 'attending') Katılıyor
                                        @elseif($rsvp->status === 'not_attending') Katılamıyor
                                        @else Belki @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-night-700 dark:text-cream-300 tabular-nums">{{ $rsvp->guest_count }}</td>
                                <td class="px-6 py-4 text-sm text-night-600 dark:text-cream-300 font-medium">
                                    <a href="{{ route('user.invitations.edit', $rsvp->invitation) }}" class="hover:text-gold-600 dark:hover:text-gold-400 transition-colors">
                                        {{ $rsvp->invitation->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-night-400 dark:text-cream-400 max-w-[180px] truncate" title="{{ $rsvp->message ?? '' }}">{{ $rsvp->message ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-night-400 dark:text-cream-400 whitespace-nowrap">{{ $rsvp->created_at->format('d.m.Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        @if(!$rsvp->is_confirmed)
                                            <form method="POST" action="{{ route('user.rsvps.confirm', $rsvp) }}" class="inline">
                                                @csrf
                                                <button class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors" title="Onayla">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('user.rsvps.reject', $rsvp) }}" class="inline">
                                                @csrf
                                                <button class="p-1.5 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors" title="Reddet">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Onaylı</span>
                                        @endif
                                        <form method="POST" action="{{ route('user.rsvps.destroy', $rsvp) }}" class="inline" onsubmit="return confirm('Bu katılımcıyı silmek istediğine emin misin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-1.5 rounded-lg bg-gray-50 dark:bg-night-700 text-gray-400 dark:text-cream-400 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-500 dark:hover:text-red-400 transition-colors" title="Sil">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($rsvps->hasPages())
                    <div class="px-6 py-4 border-t border-cream-100 dark:border-night-700 bg-cream-50/30 dark:bg-night-900/30">{{ $rsvps->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>

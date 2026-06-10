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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cream-50 dark:divide-night-700/50">
                            @foreach($rsvps as $rsvp)
                            <tr class="hover:bg-cream-50/50 dark:hover:bg-gold-500/5 transition-colors">
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

<x-admin-layout>
    <x-slot name="header">
        <div>
            {{ $user->name }} - Davetiyeleri
            <span class="sub">Kullanıcıya ait tüm davetiyeler</span>
        </div>
    </x-slot>
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn-ghost text-sm">← Kullanıcılara Dön</a>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Durum</th>
                        <th>Görüntülenme</th>
                        <th>RSVP</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invitations as $invitation)
                        <tr>
                            <td class="font-medium">{{ $invitation->title }}</td>
                            <td>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg {{ $invitation->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $invitation->is_published ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                    {{ $invitation->is_published ? 'Yayında' : 'Taslak' }}
                                </span>
                            </td>
                            <td>{{ $invitation->views }}</td>
                            <td>{{ $invitation->rsvps_count }}</td>
                            <td class="text-gray-400">{{ $invitation->created_at->format('d.m.Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-400 py-10">Henüz davetiye bulunmuyor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($invitations, 'links'))
        <div class="mt-4">{{ $invitations->links() }}</div>
    @endif
</x-admin-layout>

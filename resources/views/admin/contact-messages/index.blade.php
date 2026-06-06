<x-admin-layout>
    <x-slot name="header">
        <div>
            İletişim Mesajları
            <span class="sub">Ziyaretçilerden gelen mesajlar</span>
        </div>
    </x-slot>
    <div class="glass-card overflow-hidden">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:22%">Ad</th>
                        <th style="width:18%">E-posta</th>
                        <th style="width:14%">Telefon</th>
                        <th style="width:30%">Mesaj</th>
                        <th style="width:10%">Tarih</th>
                        <th style="width:6%" class="text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr class="{{ !$msg->is_read ? 'bg-indigo-50/50' : '' }}">
                        <td>
                            <div class="flex items-center gap-2.5">
                                @if(!$msg->is_read)<span class="w-2 h-2 rounded-full bg-indigo-500 shrink-0"></span>@endif
                                <span class="font-medium">{{ $msg->name }}</span>
                            </div>
                        </td>
                        <td class="text-sm">{{ $msg->email ?? '-' }}</td>
                        <td class="text-sm">{{ $msg->phone ?? '-' }}</td>
                        <td class="text-sm max-w-xs truncate">{{ Str::limit($msg->message, 80) }}</td>
                        <td class="text-sm whitespace-nowrap">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="btn-ghost text-xs px-2 py-1.5">Gör</a>
                                <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Emin misiniz?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-ghost text-xs px-2 py-1.5 text-red-600 border-red-200 hover:bg-red-50">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-gray-400 py-10">Henüz mesaj yok</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($messages, 'links'))
            <div class="px-6 py-4 border-t border-gray-100">{{ $messages->links() }}</div>
        @endif
    </div>
</x-admin-layout>

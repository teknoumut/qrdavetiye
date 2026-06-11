<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                Kullanıcı Yönetimi
                <span class="sub">Tüm kullanıcıları görüntüleyin ve yönetin</span>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Yeni Kullanıcı</a>
        </div>
    </x-slot>
    <div class="glass-card overflow-hidden">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:28%">Ad</th>
                        <th style="width:22%">E-posta</th>
                        <th style="width:12%">Durum</th>
                        <th style="width:15%">Üyelik</th>
                        <th style="width:8%">Davetiye</th>
                        <th style="width:15%" class="text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3" style="white-space:nowrap">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="font-medium" style="overflow:hidden;text-overflow:ellipsis">{{ $user->name }}</div>
                                @if($user->is_admin)<span class="text-[10px] font-semibold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full shrink-0">Admin</span>@endif
                            </div>
                        </td>
                        <td class="font-medium" style="overflow:hidden;text-overflow:ellipsis;max-width:200px;white-space:nowrap">{{ $user->email }}</td>
                        <td>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-400' }}" style="white-space:nowrap">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td style="white-space:nowrap">
                            @if($user->subscription_end)
                                <span class="font-medium {{ $user->subscription_end->isPast() ? 'text-red-600' : 'text-gray-900' }}">{{ $user->subscription_end->format('d.m.Y') }}</span>
                                @if($user->subscription_end->isPast())
                                    <span class="text-red-600 text-xs font-medium">(Süresi doldu)</span>
                                @elseif($user->isExpiringSoon())
                                    <span class="text-yellow-600 text-xs font-medium">(Yakında bitiyor)</span>
                                @endif
                            @else
                                <span class="text-gray-400">Belirtilmemiş</span>
                            @endif
                        </td>
                        <td class="font-medium">{{ $user->invitations_count }}</td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1" style="white-space:nowrap">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-ghost text-xs px-2 py-1.5">Düzenle</a>
                                <a href="{{ route('admin.users.invitations', $user) }}" class="btn-ghost text-xs px-2 py-1.5">Davetiyeler</a>
                                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-ghost text-xs px-2 py-1.5 {{ $user->is_active ? 'text-red-600 border-red-200 hover:bg-red-50' : 'text-emerald-600 border-emerald-200 hover:bg-emerald-50' }}">
                                        {{ $user->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ $user->is_admin ? 'Admin yetkisini almak istediğinize emin misiniz?' : 'Bu kullanıcıya admin yetkisi vermek istediğinize emin misiniz?' }}')">
                                    @csrf
                                    <button type="submit" class="btn-ghost text-xs px-2 py-1.5 {{ $user->is_admin ? 'text-orange-600 border-orange-200 hover:bg-orange-50' : 'text-indigo-600 border-indigo-200 hover:bg-indigo-50' }}">
                                        {{ $user->is_admin ? 'Admini Kaldır' : 'Admin Yap' }}
                                    </button>
                                </form>
                                @if(!$user->is_admin)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Emin misiniz?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-ghost text-xs px-2 py-1.5 text-red-600 border-red-200 hover:bg-red-50">Sil</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($users, 'links'))
            <div class="px-6 py-4 border-t border-gray-100">{{ $users->links() }}</div>
        @endif
    </div>
</x-admin-layout>

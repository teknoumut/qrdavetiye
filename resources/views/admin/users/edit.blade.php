<x-admin-layout>
    <x-slot name="header">
        <div>
            Kullanıcı Düzenle: {{ $user->name }}
            <span class="sub">Kullanıcı bilgilerini güncelleyin</span>
        </div>
    </x-slot>
    <div class="bg-white border border-gray-200 rounded-2xl p-8 max-w-2xl">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <div class="relative group">
                @if($user->photo_url)
                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold">
                        {{ $user->initial }}
                    </div>
                @endif
                @if($user->isOnline())
                    <span class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                @endif
                <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('adminPhotoUpload').click()">
                    <span class="text-white text-xs font-semibold">Değiştir</span>
                </div>
                <form action="{{ route('admin.users.photo.upload', $user) }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" name="photo" id="adminPhotoUpload" accept="image/jpg,image/jpeg,image/png,image/webp" onchange="this.form.submit()">
                </form>
            </div>
            <div>
                <div class="text-lg font-bold text-gray-900">{{ $user->name }}</div>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                <div class="flex items-center gap-2 mt-1">
                    @if($user->isOnline())
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Çevrimiçi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            @if($user->last_seen_at)
                                {{ $user->last_seen_at->diffForHumans() }}
                            @else
                                Hiç çevrimiçi olmadı
                            @endif
                        </span>
                    @endif
                    @if($user->profile_photo_path)
                        <form action="{{ route('admin.users.photo.delete', $user) }}" method="POST" onsubmit="return confirm('Fotoğrafı kaldırmak istediğinize emin misiniz?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold">Kaldır</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-5">
                <label>Ad Soyad</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-5">
                <label>E-posta</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-5">
                <label>Yeni Şifre (boş bırakılırsa değişmez)</label>
                <input type="password" name="password">
            </div>
            @unless ($user->is_admin)
            <div class="mb-5">
                <label>Plan</label>
                <select name="plan_id">
                    <option value="">Seçiniz</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" {{ $user->plan_id == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} ({{ $plan->max_invitations == -1 ? 'Sınırsız' : $plan->max_invitations.' davetiye' }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endunless
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label>Başlangıç Tarihi</label>
                    <input type="date" name="subscription_start" value="{{ old('subscription_start', $user->subscription_start?->format('Y-m-d')) }}">
                </div>
                <div>
                    <label>Bitiş Tarihi</label>
                    <input type="date" name="subscription_end" value="{{ old('subscription_end', $user->subscription_end?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2.5 cursor-pointer" style="font-weight:500;text-transform:none;letter-spacing:normal">
                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5">
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Güncelle</button>
            </div>
        </form>
        @unless ($user->is_admin)
        <hr class="my-6 border-gray-200">
        <form action="{{ route('admin.users.extend-subscription', $user) }}" method="POST" class="flex items-end gap-3 mb-3">
            @csrf
            <div>
                <label>Süre Uzat (Gün)</label>
                <input type="number" name="days" min="1" max="365" value="30" style="width:100px">
            </div>
            <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#10b981,#059669)">Süre Uzat</button>
        </form>
        <form action="{{ route('admin.users.extend-subscription', $user) }}" method="POST" class="flex items-end gap-3">
            @csrf
            <input type="hidden" name="days" value="36500">
            <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)">Sınırsız Yap (100 yıl)</button>
        </form>
        @endunless
    </div>
</x-admin-layout>

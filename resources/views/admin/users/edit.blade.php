<x-admin-layout>
    <x-slot name="header">
        <div>
            Kullanıcı Düzenle: {{ $user->name }}
            <span class="sub">Kullanıcı bilgilerini güncelleyin</span>
        </div>
    </x-slot>
    <div class="bg-white border border-gray-200 rounded-2xl p-8 max-w-2xl">
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

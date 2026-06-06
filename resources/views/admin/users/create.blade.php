<x-admin-layout>
    <x-slot name="header">
        <div>
            Yeni Kullanıcı Oluştur
            <span class="sub">Sisteme yeni bir kullanıcı ekleyin</span>
        </div>
    </x-slot>
    <div class="bg-white border border-gray-200 rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label>Ad Soyad</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label>E-posta</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label>Şifre</label>
                <input type="password" name="password" required>
                @error('password')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label>Plan</label>
                <select name="plan_id">
                    <option value="">Seçiniz</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} ({{ $plan->max_invitations == -1 ? 'Sınırsız' : $plan->max_invitations.' davetiye' }})
                        </option>
                    @endforeach
                </select>
                @error('plan_id')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label>Başlangıç Tarihi</label>
                    <input type="date" name="subscription_start" value="{{ old('subscription_start') }}">
                </div>
                <div>
                    <label>Bitiş Tarihi</label>
                    <input type="date" name="subscription_end" value="{{ old('subscription_end') }}">
                </div>
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2.5 cursor-pointer" style="font-weight:500;text-transform:none;letter-spacing:normal">
                    <input type="checkbox" name="is_active" value="1" checked style="width:18px;height:18px;accent-color:#4f46e5">
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Oluştur</button>
            </div>
        </form>
    </div>
</x-admin-layout>

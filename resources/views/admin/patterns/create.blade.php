<x-admin-layout>
    <x-slot name="header">
        <div>
            Yeni Desen
            <span class="sub">Zarf için yeni bir desen görseli yükleyin</span>
        </div>
    </x-slot>
    <div class="glass-card rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('admin.patterns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label>Desen Adı</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Örn: Çiçek Deseni">
                @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label>Desen Görseli</label>
                <div class="mt-1.5">
                    <input type="file" name="image" accept="image/png,image/jpeg,image/svg+xml,image/webp" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:text-white file:bg-gradient-to-r file:from-gold-500 file:to-rose-500 file:cursor-pointer cursor-pointer focus:border-gold-400 focus:ring-2 focus:ring-gold-100 outline-none transition-all">
                    @error('image') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }} class="rounded border-gray-300 text-amber-500 focus:ring-amber-400">
                    <span class="text-sm font-medium text-gray-700">Premium Desen <span class="text-[10px] font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">PREMIUM</span></span>
                </label>
                <p class="text-xs text-gray-400 mt-1 ml-6">Sadece premium paket kullanıcıları bu deseni görebilir.</p>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-[rgba(255,255,255,0.06)]">
                <a href="{{ route('admin.patterns.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Yükle</button>
            </div>
        </form>
    </div>
</x-admin-layout>

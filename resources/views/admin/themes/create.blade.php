<x-admin-layout>
    <x-slot name="header">
        <div>
            Yeni Tema
            <span class="sub">Yeni bir davetiye teması ekleyin</span>
        </div>
    </x-slot>
    <div class="glass-card rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('admin.themes.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label>Tema Adı</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-5">
                <label>Açıklama</label>
                <textarea name="description" rows="2">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label>Ana Renk</label>
                    <input type="color" name="primary_color" value="{{ old('primary_color', '#d4af37') }}" style="height:44px;padding:4px">
                </div>
                <div>
                    <label>İkincil Renk</label>
                    <input type="color" name="secondary_color" value="{{ old('secondary_color', '#ffffff') }}" style="height:44px;padding:4px">
                </div>
            </div>
            <div class="mb-5">
                <label>Blade Şablon</label>
                <input type="text" name="blade_template" value="{{ old('blade_template', 'classic') }}" required>
            </div>
            <div class="mb-5">
                <label>Yazı Tipi</label>
                <input type="text" name="font_family" value="{{ old('font_family') }}" placeholder="Örn: Georgia, serif">
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
                    <input type="checkbox" name="is_premium" value="1" style="width:18px;height:18px;accent-color:#6366f1">
                    <span class="text-sm font-medium text-[#e2e8f0]">Premium Tema</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-[rgba(255,255,255,0.06)]">
                <a href="{{ route('admin.themes.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Oluştur</button>
            </div>
        </form>
    </div>
</x-admin-layout>

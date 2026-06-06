<x-admin-layout>
    <x-slot name="header">
        <div>
            Tema Düzenle: {{ $theme->name }}
            <span class="sub">Tema bilgilerini güncelleyin</span>
        </div>
    </x-slot>
    <div class="glass-card rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('admin.themes.update', $theme) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-5">
                <label>Tema Adı</label>
                <input type="text" name="name" value="{{ old('name', $theme->name) }}" required>
            </div>
            <div class="mb-5">
                <label>Açıklama</label>
                <textarea name="description" rows="2">{{ old('description', $theme->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label>Ana Renk</label>
                    <input type="color" name="primary_color" value="{{ old('primary_color', $theme->primary_color) }}" style="height:44px;padding:4px">
                </div>
                <div>
                    <label>İkincil Renk</label>
                    <input type="color" name="secondary_color" value="{{ old('secondary_color', $theme->secondary_color) }}" style="height:44px;padding:4px">
                </div>
            </div>
            <div class="mb-5">
                <label>Blade Şablon</label>
                <input type="text" name="blade_template" value="{{ old('blade_template', $theme->blade_template) }}" required>
            </div>
            <div class="mb-5">
                <label>Yazı Tipi</label>
                <input type="text" name="font_family" value="{{ old('font_family', $theme->font_family) }}">
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
                    <input type="checkbox" name="is_premium" value="1" {{ $theme->is_premium ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
                    <span class="text-sm font-medium text-[#e2e8f0]">Premium Tema</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-[rgba(255,255,255,0.06)]">
                <a href="{{ route('admin.themes.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Güncelle</button>
            </div>
        </form>
    </div>
</x-admin-layout>

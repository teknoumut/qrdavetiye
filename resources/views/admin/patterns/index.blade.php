<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                Desen Yönetimi
                <span class="sub">Zarf desenlerini yükleyin ve yönetin</span>
            </div>
            <a href="{{ route('admin.patterns.create') }}" class="btn-primary">+ Yeni Desen</a>
        </div>
    </x-slot>
    @if(session('success'))
        <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 px-5 py-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium">{{ session('error') }}</div>
    @endif
    @if($patterns->count() === 0)
        <div class="text-center py-20">
            <span class="text-5xl block mb-4 opacity-30">🖼️</span>
            <p class="text-gray-400 font-medium">Henüz desen eklenmemiş</p>
            <a href="{{ route('admin.patterns.create') }}" class="btn-primary mt-4 inline-block">İlk Deseni Ekle</a>
        </div>
    @else
        <form id="massDeleteForm" action="{{ route('admin.patterns.mass-destroy') }}" method="POST">
            @csrf @method('DELETE')
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Tümünü Seç</span>
                </label>
                <button type="submit" id="massDeleteBtn" class="px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed" disabled onclick="return confirm('Seçilen desenleri silmek istediğinize emin misiniz?')">Seçilenleri Sil</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($patterns as $pattern)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="aspect-square bg-cream-50 relative overflow-hidden">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($pattern->image_path) }}" class="w-full h-full object-cover">
                            <div class="absolute top-2 left-2">
                                <input type="checkbox" name="ids[]" value="{{ $pattern->id }}" class="pattern-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="p-3.5">
                            <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $pattern->name }}</h3>
                            <div class="flex items-center mt-1.5 gap-2">
                                @if($pattern->is_premium)
                                    <span class="text-[10px] font-semibold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full border border-amber-200">Premium</span>
                                @endif
                                @if($pattern->is_active)
                                    <span class="text-[10px] font-semibold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full border border-emerald-200">Aktif</span>
                                @endif
                            </div>
                            <div class="flex mt-3 gap-1.5 pt-2.5 border-t border-gray-100">
                                <a href="{{ route('admin.patterns.edit', $pattern) }}" class="flex-1 text-center btn-ghost text-xs py-1.5">Düzenle</a>
                                <form action="{{ route('admin.patterns.destroy', $pattern) }}" method="POST" class="flex-1" onsubmit="return confirm('Emin misiniz?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full text-center btn-ghost text-xs py-1.5 text-red-600 border-red-200 hover:bg-red-50">Sil</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
        <script>
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.pattern-checkbox');
            const massDeleteBtn = document.getElementById('massDeleteBtn');

            function updateMassDeleteBtn() {
                const checked = document.querySelectorAll('.pattern-checkbox:checked').length;
                massDeleteBtn.disabled = checked === 0;
            }

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateMassDeleteBtn();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) selectAll.checked = false;
                    const allChecked = document.querySelectorAll('.pattern-checkbox:checked').length === checkboxes.length;
                    selectAll.checked = allChecked;
                    updateMassDeleteBtn();
                });
            });
        </script>
    @endif
</x-admin-layout>

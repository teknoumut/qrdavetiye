<x-admin-layout>
    <x-slot name="header">
        <div>
            Yeni Paket
            <span class="sub">Yeni bir üyelik paketi oluşturun</span>
        </div>
    </x-slot>
    <div class="glass-card rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf
            @include('admin.plans._form')
            <div class="flex justify-end gap-3 pt-4 border-t border-[rgba(255,255,255,0.06)]">
                <a href="{{ route('admin.plans.index') }}" class="btn-ghost">İptal</a>
                <button type="submit" class="btn-primary">Oluştur</button>
            </div>
        </form>
    </div>
</x-admin-layout>

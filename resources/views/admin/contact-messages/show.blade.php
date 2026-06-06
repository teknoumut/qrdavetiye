<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                Mesaj
                <span class="sub">{{ $contactMessage->name }} tarafından gönderildi</span>
            </div>
            <a href="{{ route('admin.contact-messages.index') }}" class="btn-ghost">&larr; Geri</a>
        </div>
    </x-slot>
    <div class="max-w-3xl">
        <div class="bg-white border border-gray-200 rounded-2xl p-8">
            <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-100">
                <div>
                    <label class="text-xs text-gray-400 uppercase tracking-wide">Ad Soyad</label>
                    <p class="text-gray-900 font-medium mt-1">{{ $contactMessage->name }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-400 uppercase tracking-wide">Tarih</label>
                    <p class="text-gray-900 font-medium mt-1">{{ $contactMessage->created_at->format('d.m.Y H:i') }}</p>
                </div>
                @if($contactMessage->email)
                <div>
                    <label class="text-xs text-gray-400 uppercase tracking-wide">E-posta</label>
                    <p class="text-gray-900 font-medium mt-1">
                        <a href="mailto:{{ $contactMessage->email }}" class="text-indigo-600 hover:text-indigo-800">{{ $contactMessage->email }}</a>
                    </p>
                </div>
                @endif
                @if($contactMessage->phone)
                <div>
                    <label class="text-xs text-gray-400 uppercase tracking-wide">Telefon</label>
                    <p class="text-gray-900 font-medium mt-1">
                        <a href="tel:{{ $contactMessage->phone }}" class="text-indigo-600 hover:text-indigo-800">{{ $contactMessage->phone }}</a>
                    </p>
                </div>
                @endif
            </div>
            <div>
                <label class="text-xs text-gray-400 uppercase tracking-wide mb-2 block">Mesaj</label>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contactMessage->message }}</p>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                <span class="text-xs text-gray-400">
                    {{ $contactMessage->is_read ? 'Okundu' : 'Okunmadı' }}
                </span>
                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Emin misiniz?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-ghost text-red-600 border-red-200 hover:bg-red-50">Mesajı Sil</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

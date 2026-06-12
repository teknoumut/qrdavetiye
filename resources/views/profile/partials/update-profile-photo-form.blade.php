<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profil Resmi') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Bir profil resmi yükleyin veya mevcut resmi değiştirin.') }}
        </p>
    </header>

    <div class="mt-6 flex items-center gap-6">
        <div class="relative">
            @if($user->photo_url)
                <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
            @else
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ $user->initial }}
                </div>
            @endif
            @if($user->isOnline())
                <span class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
            @endif
        </div>

        <div class="space-y-3">
            <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data" id="photoUploadForm">
                @csrf
                <input type="file" name="photo" id="photo" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden" onchange="document.getElementById('photoUploadForm').submit()">
                <button type="button" onclick="document.getElementById('photo').click()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                    {{ __('Resim Seç') }}
                </button>
                <p class="text-xs text-gray-500 mt-1">JPG, PNG veya WebP. Maks. 2MB.</p>
            </form>

            @if($user->profile_photo_path)
                <form action="{{ route('profile.photo.delete') }}" method="POST" onsubmit="return confirm('{{ __('Profil resmini kaldırmak istediğinize emin misiniz?') }}')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold">
                        {{ __('Resmi Kaldır') }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('status') === 'photo-updated')
        <p class="mt-2 text-sm text-emerald-600 font-medium">{{ __('Profil resmi güncellendi.') }}</p>
    @elseif(session('status') === 'photo-deleted')
        <p class="mt-2 text-sm text-emerald-600 font-medium">{{ __('Profil resmi kaldırıldı.') }}</p>
    @endif

    @error('photo')
        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
    @enderror
</section>

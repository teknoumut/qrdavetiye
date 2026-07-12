<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-night-900 dark:text-cream-100">Kullanıcı Yorumları</h1>
            <p class="text-night-500 dark:text-cream-400 mt-2">senin 💝 davetiyen kullanıcılarının deneyimleri</p>
        </div>

        @auth
            <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-6 mb-8">
                <h2 class="text-lg font-bold text-night-900 dark:text-cream-100 mb-4">Yorum Yap</h2>
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-2">Puan</label>
                        <div class="flex gap-2" x-data="{ rating: 0 }">
                            <template x-for="i in 5">
                                <button type="button" @click="rating = i" class="text-2xl transition-colors" :class="i <= rating ? 'text-yellow-400' : 'text-cream-300 dark:text-night-500'">★</button>
                            </template>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-2">Yorum</label>
                        <textarea name="content" rows="4" class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" required></textarea>
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm text-night-600 dark:text-cream-300 cursor-pointer">
                            <input type="checkbox" name="is_anonymous" value="1" class="rounded border-cream-300 dark:border-night-600 text-gold-500 focus:ring-gold-400">
                            <span>Soyadım görünmesin</span>
                        </label>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-gold-400 to-rose-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all">Gönder</button>
                </form>
            </div>
        @endauth

        @forelse ($reviews as $review)
            <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 p-6 mb-4">
                <div class="flex items-center gap-3 mb-3">
                    @if($review->user->photo_url)
                        <img src="{{ $review->user->photo_url }}" alt="" class="w-10 h-10 rounded-xl object-cover">
                    @else
                        <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center text-sm font-bold text-white">{{ substr($review->user->name, 0, 1) }}</span>
                    @endif
                    <div>
                        <p class="font-semibold text-night-900 dark:text-cream-100">{{ $review->is_anonymous ? explode(' ', $review->user->name)[0] : $review->user->name }}</p>
                        <p class="text-xs text-night-400 dark:text-cream-400">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="ml-auto flex gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-cream-300 dark:text-night-500' }}">★</span>
                        @endfor
                    </div>
                </div>
                <p class="text-night-600 dark:text-cream-300 text-sm leading-relaxed">{{ $review->content }}</p>
            </div>
        @empty
            <div class="text-center py-12 text-night-400 dark:text-cream-400">
                <p class="text-lg">Henüz yorum bulunmuyor.</p>
                <p class="text-sm mt-1">İlk yorumu siz yapın!</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>
</x-app-layout>

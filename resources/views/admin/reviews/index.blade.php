@php $header = 'Yorum Yönetimi' @endphp
<x-admin-layout>
    <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-cream-50 dark:bg-night-900/50 border-b border-cream-200 dark:border-night-700">
                        <th class="text-left px-5 py-4 font-semibold text-night-600 dark:text-cream-300">Kullanıcı</th>
                        <th class="text-left px-5 py-4 font-semibold text-night-600 dark:text-cream-300">Puan</th>
                        <th class="text-left px-5 py-4 font-semibold text-night-600 dark:text-cream-300">Yorum</th>
                        <th class="text-left px-5 py-4 font-semibold text-night-600 dark:text-cream-300">Tarih</th>
                        <th class="text-left px-5 py-4 font-semibold text-night-600 dark:text-cream-300">Durum</th>
                        <th class="text-right px-5 py-4 font-semibold text-night-600 dark:text-cream-300">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr class="border-b border-cream-100 dark:border-night-700 hover:bg-cream-50/50 dark:hover:bg-night-700/30 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-gold-300 to-rose-400 flex items-center justify-center text-xs font-bold text-white">{{ substr($review->user->name, 0, 1) }}</span>
                                    <span class="font-medium text-night-800 dark:text-cream-200">{{ $review->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-cream-300 dark:text-night-500' }}">★</span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-5 py-4 text-night-700 dark:text-cream-300 max-w-xs truncate">{{ $review->content }}</td>
                            <td class="px-5 py-4 text-night-500 dark:text-cream-400 text-xs">{{ $review->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4">
                                @if ($review->is_approved)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300">Onaylı</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300">Bekliyor</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if (!$review->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Onayla</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-night-400 dark:text-cream-400">Henüz yorum yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('admin.reviews.mass-destroy') }}" onsubmit="return confirm('Tüm yorumları silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 text-sm font-semibold bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">🗑️ Tümünü Sil</button>
        </form>
        <div>{{ $reviews->links() }}</div>
    </div>
</x-admin-layout>

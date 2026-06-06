<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-start sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-gold-400 to-rose-500 flex items-center justify-center text-white font-bold shadow-lg shrink-0">
                        {{ substr($invitation->groom_name ?: 'D', 0, 1) }}{{ substr($invitation->bride_name ?: 'V', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-xl font-bold text-night-900 dark:text-cream-100 truncate">{{ $invitation->title ?: 'Yeni Davetiye' }}</h1>
                        <p class="text-sm text-night-400 dark:text-cream-400 truncate">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($invitation->is_published)
                    <form action="{{ route('user.invitations.unpublish', $invitation) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-night-800 text-night-500 dark:text-cream-300 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Yayından Kaldır
                        </button>
                    </form>
                @else
                    <form action="{{ route('user.invitations.publish', $invitation) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-500/20 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Yayınla
                        </button>
                    </form>
                @endif
                <a href="{{ route('user.invitations.preview', $invitation) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-night-800 text-night-500 dark:text-cream-300 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Önizle
                </a>
                <a href="{{ route('user.invitations.show', $invitation) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-night-800 text-night-500 dark:text-cream-300 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    İstatistikler
                </a>
            </div>
        </div>
    </x-slot>

    <div x-data="{ tab: 'info' }">
        <div class="bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 rounded-2xl p-1.5 shadow-sm inline-flex gap-0.5 mb-6 sm:mb-8 overflow-x-auto w-full sm:w-auto">
            <button @click="tab = 'info'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'info' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">📝</span>
                <span>Bilgiler</span>
            </button>
            <button @click="tab = 'design'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'design' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🎨</span>
                <span>Tasarım</span>
            </button>
            <button @click="tab = 'photos'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'photos' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🖼️</span>
                <span>Fotoğraflar</span>
            </button>
            <button @click="tab = 'music'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'music' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🎵</span>
                <span>Müzik & Video</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <template x-if="tab === 'info'">
                    <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">📋</span>
                                <div>
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">Davetiye Bilgileri</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">Çift ve etkinlik bilgilerini gir</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.update', $invitation) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">🎪 Etkinlik Türü</label>
                                        <div class="relative">
                                            <select name="event_type" id="editEventTypeSelect"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                <option value="wedding" {{ ($invitation->event_type ?: 'wedding') === 'wedding' ? 'selected' : '' }}>💍 Düğün</option>
                                                <option value="engagement" {{ ($invitation->event_type ?: 'wedding') === 'engagement' ? 'selected' : '' }}>💍 Nişan</option>
                                                <option value="circumcision" {{ ($invitation->event_type ?: 'wedding') === 'circumcision' ? 'selected' : '' }}>✂️ Sünnet</option>
                                                <option value="birthday" {{ ($invitation->event_type ?: 'wedding') === 'birthday' ? 'selected' : '' }}>🎂 Doğum Günü</option>
                                                <option value="corporate" {{ ($invitation->event_type ?: 'wedding') === 'corporate' ? 'selected' : '' }}>🏢 Kurumsal</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="editCoupleFields">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                            <div>
                                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="editGroomLabel">👨 Damat Adı</label>
                                                <input type="text" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="editGroomInput">
                                            </div>
                                            <div id="editBrideField">
                                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="editBrideLabel">👰 Gelin Adı</label>
                                                <input type="text" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" required
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="editBrideInput">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mt-4 sm:mt-5" id="editGroomParents">
                                            <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700">
                                                <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                    <span>👪</span> <span id="editGroomParentTitle">Damat Ailesi</span>
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editGroomFatherLabel">Baba Adı</label>
                                                        <input type="text" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" placeholder="Mehmet"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                    <div id="editGroomMotherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editGroomMotherLabel">Anne Adı</label>
                                                        <input type="text" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" placeholder="Ayşe"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700" id="editBrideParents">
                                                <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                    <span>👪</span> <span id="editBrideParentTitle">Gelin Ailesi</span>
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div id="editBrideFatherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editBrideFatherLabel">Baba Adı</label>
                                                        <input type="text" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" placeholder="Ahmet"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                    <div id="editBrideMotherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editBrideMotherLabel">Anne Adı</label>
                                                        <input type="text" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" placeholder="Fatma"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Başlık</label>
                                        <input type="text" name="title" value="{{ old('title', $invitation->title) }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" placeholder="Düğün Davetiyesi">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">🔗 Kısa Link</label>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-night-400 dark:text-cream-400 shrink-0">{{ url('/s/') }}</span>
                                            <input type="text" name="short_link" value="{{ old('short_link', $invitation->short_link) }}"
                                                class="flex-1 w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all font-mono" placeholder="ozel-davetiyem-2025" pattern="[a-z0-9-]+">
                                        </div>
                                        <p class="text-xs text-night-400 dark:text-cream-400 mt-1.5">Sadece küçük harf, rakam ve tire kullanın. Paylaşım linkiniz kısalır.</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">📅 Tarih</label>
                                            <div class="relative">
                                                <input type="date" name="event_date" value="{{ old('event_date', $invitation->event_date?->format('Y-m-d')) }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">⏰ Saat</label>
                                            <input type="time" name="event_time" value="{{ old('event_time', $invitation->event_time) }}"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">📍 Adres</label>
                                        <textarea name="event_address" rows="2"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('event_address', $invitation->event_address) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">💬 Karşılama Mesajı</label>
                                        <textarea name="welcome_message" rows="3"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('welcome_message', $invitation->welcome_message) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">💕 Hikayeniz</label>
                                        <textarea name="story" rows="4"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('story', $invitation->story) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">📝 Özel Not</label>
                                        <textarea name="special_note" rows="2"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('special_note', $invitation->special_note) }}</textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-6 mt-6 border-t border-cream-100 dark:border-night-700">
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 hover:-translate-y-0.5 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Bilgileri Kaydet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>

                <template x-if="tab === 'design'">
                    <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🎨</span>
                                <div>
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">Tema ve Tasarım</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">Davetiyenin görünümünü özelleştir</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.update', $invitation) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                @if($errors->any())
                                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 mb-4">
                                        <p class="text-sm font-semibold text-red-600 dark:text-red-400">Hata oluştu. Lütfen hataları düzeltip tekrar kaydedin.</p>
                                    </div>
                                @endif
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Tema</label>
                                            <div class="relative">
                                                <select name="theme"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    @foreach($themes as $theme)
                                                        <option value="{{ $theme->slug }}" {{ $invitation->theme === $theme->slug ? 'selected' : '' }}>{{ $theme->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Zarf Animasyonu</label>
                                            <div class="relative">
                                                <select name="envelope_animation"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    <option value="classic" {{ $invitation->envelope_animation === 'classic' ? 'selected' : '' }}>Klasik (Zarf Açılır)</option>
                                                    <option value="heart" {{ $invitation->envelope_animation === 'heart' ? 'selected' : '' }}>Kalp Patlaması</option>
                                                    <option value="magic" {{ $invitation->envelope_animation === 'magic' ? 'selected' : '' }}>Sihirli Işıltı</option>
                                                    <option value="flip" {{ $invitation->envelope_animation === 'flip' ? 'selected' : '' }}>3D Dönüş</option>
                                                    <option value="ripple" {{ $invitation->envelope_animation === 'ripple' ? 'selected' : '' }}>Dalga Efekti</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Yazı Tipi</label>
                                            <div class="relative">
                                                <select name="font_family"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    <optgroup label="Lüks ve Premium">
                                                        <option value="Cinzel" {{ $invitation->font_family === 'Cinzel' ? 'selected' : '' }}>Cinzel</option>
                                                        <option value="Cormorant Garamond" {{ $invitation->font_family === 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond</option>
                                                        <option value="Playfair Display" {{ $invitation->font_family === 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                                                        <option value="Bodoni Moda" {{ $invitation->font_family === 'Bodoni Moda' ? 'selected' : '' }}>Bodoni Moda</option>
                                                        <option value="DM Serif Display" {{ $invitation->font_family === 'DM Serif Display' ? 'selected' : '' }}>DM Serif Display</option>
                                                    </optgroup>
                                                    <optgroup label="Modern ve Temiz">
                                                        <option value="Montserrat" {{ $invitation->font_family === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                                        <option value="Poppins" {{ $invitation->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                                                        <option value="Inter" {{ $invitation->font_family === 'Inter' ? 'selected' : '' }}>Inter</option>
                                                        <option value="Manrope" {{ $invitation->font_family === 'Manrope' ? 'selected' : '' }}>Manrope</option>
                                                        <option value="Outfit" {{ $invitation->font_family === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                                                        <option value="Plus Jakarta Sans" {{ $invitation->font_family === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans</option>
                                                    </optgroup>
                                                    <optgroup label="Teknoloji ve Yazılım">
                                                        <option value="Space Grotesk" {{ $invitation->font_family === 'Space Grotesk' ? 'selected' : '' }}>Space Grotesk</option>
                                                        <option value="Sora" {{ $invitation->font_family === 'Sora' ? 'selected' : '' }}>Sora</option>
                                                        <option value="Exo 2" {{ $invitation->font_family === 'Exo 2' ? 'selected' : '' }}>Exo 2</option>
                                                        <option value="Orbitron" {{ $invitation->font_family === 'Orbitron' ? 'selected' : '' }}>Orbitron</option>
                                                        <option value="Rajdhani" {{ $invitation->font_family === 'Rajdhani' ? 'selected' : '' }}>Rajdhani</option>
                                                    </optgroup>
                                                    <optgroup label="Kalın ve Dikkat Çekici">
                                                        <option value="Bebas Neue" {{ $invitation->font_family === 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue</option>
                                                        <option value="Anton" {{ $invitation->font_family === 'Anton' ? 'selected' : '' }}>Anton</option>
                                                        <option value="League Spartan" {{ $invitation->font_family === 'League Spartan' ? 'selected' : '' }}>League Spartan</option>
                                                        <option value="Oswald" {{ $invitation->font_family === 'Oswald' ? 'selected' : '' }}>Oswald</option>
                                                        <option value="Teko" {{ $invitation->font_family === 'Teko' ? 'selected' : '' }}>Teko</option>
                                                    </optgroup>
                                                    <optgroup label="İmza ve Şık Yazılar">
                                                        <option value="Great Vibes" {{ $invitation->font_family === 'Great Vibes' ? 'selected' : '' }}>Great Vibes</option>
                                                        <option value="Allura" {{ $invitation->font_family === 'Allura' ? 'selected' : '' }}>Allura</option>
                                                        <option value="Parisienne" {{ $invitation->font_family === 'Parisienne' ? 'selected' : '' }}>Parisienne</option>
                                                        <option value="Alex Brush" {{ $invitation->font_family === 'Alex Brush' ? 'selected' : '' }}>Alex Brush</option>
                                                        <option value="Brittany Signature" {{ $invitation->font_family === 'Brittany Signature' ? 'selected' : '' }}>Brittany Signature</option>
                                                        <option value="Anydore" {{ $invitation->font_family === 'Anydore' ? 'selected' : '' }}>Anydore</option>
                                                    </optgroup>
                                                    <optgroup label="Diğer">
                                                        <option value="Lora" {{ $invitation->font_family === 'Lora' ? 'selected' : '' }}>Lora</option>
                                                        <option value="Blacksword" {{ $invitation->font_family === 'Blacksword' ? 'selected' : '' }}>Blacksword</option>
                                                    </optgroup>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div x-data="{ selectedPattern: '{{ old('envelope_pattern', $invitation->envelope_pattern ?: '') }}' }">
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-3">Zarf Deseni</label>

                                        <div class="grid grid-cols-4 sm:grid-cols-4 gap-2.5 mb-4">
                                            <template x-for="p in window.envPatterns" :key="p.v">
                                                <button type="button"
                                                    @click="selectedPattern = p.v"
                                                    class="relative flex flex-col items-center gap-2 p-2 rounded-xl border-2 cursor-pointer transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-gold-400/40"
                                                    :class="selectedPattern === p.v
                                                        ? 'border-gold-500 bg-gold-50 dark:bg-gold-500/10 shadow-md'
                                                        : 'border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 hover:shadow-sm'">
                                                    <div class="w-full aspect-square rounded-lg overflow-hidden bg-gradient-to-br from-gold-400 to-gold-600 shadow-sm relative">
                                                        <div :class="'pat-prev-' + p.v" class="absolute inset-0"></div>
                                                        <template x-if="p.v === ''">
                                                            <div class="absolute inset-0 flex items-center justify-center bg-black/5 dark:bg-white/5">
                                                                <svg class="w-5 h-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                            </div>
                                                        </template>
                                                        <div x-show="selectedPattern === p.v"
                                                            class="absolute top-1 right-1 w-5 h-5 rounded-full bg-gold-500 text-white flex items-center justify-center shadow"
                                                            style="display: none;">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        </div>
                                                    </div>
                                                    <span class="text-[11px] leading-tight text-center font-semibold text-night-600 dark:text-cream-300 transition-colors" x-text="p.l"></span>
                                                </button>
                                            </template>
                                        </div>

                                        <input type="hidden" name="envelope_pattern" :value="selectedPattern">

                                        <div class="rounded-xl border-2 border-dashed border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 transition-all duration-200 overflow-hidden">
                                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                                <div class="w-10 h-10 rounded-lg bg-cream-100 dark:bg-night-700 flex items-center justify-center text-lg shrink-0 border border-cream-200 dark:border-night-600">
                                                    <span>🖼️</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <span class="text-sm font-semibold text-night-700 dark:text-cream-200 block leading-tight">Kendi Desenini Yükle</span>
                                                    <span class="text-xs text-night-400 dark:text-cream-400 block mt-0.5" id="editCustomFileLabel">PNG, JPG, SVG — 64MB'a kadar</span>
                                                </div>
                                                <div class="px-3 py-1.5 rounded-lg text-xs font-semibold text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20 hover:bg-gold-100 dark:hover:bg-gold-500/20 transition-colors shrink-0">
                                                    Gözat
                                                </div>
                                                <input type="file" name="custom_pattern" accept="image/png,image/jpeg,image/svg+xml" class="hidden"
                                                    onchange="
                                                        var label = document.getElementById('editCustomFileLabel');
                                                        if (this.files[0]) {
                                                            label.textContent = this.files[0].name;
                                                        }
                                                    ">
                                            </label>
                                            @if($invitation->custom_pattern)
                                                <div class="flex items-center gap-2.5 px-4 pb-3 pt-1 border-t border-cream-100 dark:border-night-700">
                                                    <div class="relative shrink-0">
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($invitation->custom_pattern) }}" class="w-10 h-10 rounded-lg object-cover border border-cream-200 dark:border-night-700 shadow-sm">
                                                        <span class="absolute -top-1 -right-1 text-xs bg-emerald-500 text-white rounded-full w-4 h-4 flex items-center justify-center shadow-sm">✓</span>
                                                    </div>
                                                    <span class="text-xs text-night-400 dark:text-cream-400 truncate">Mevcut desen</span>
                                                </div>
                                            @endif
                                            @error('custom_pattern')
                                                <p class="text-xs text-red-500 mt-1.5 px-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Ana Renk</label>
                                            <div class="flex gap-2 items-center">
                                                <input type="color" name="primary_color" value="{{ old('primary_color', $invitation->primary_color ?: '#d4a61e') }}"
                                                    class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ old('primary_color', $invitation->primary_color ?: '#d4a61e') }}" readonly
                                                    class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Arka Plan</label>
                                            <div class="flex gap-2 items-center">
                                                <input type="color" name="secondary_color" value="{{ old('secondary_color', $invitation->secondary_color ?: '#fefcf8') }}"
                                                    class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ old('secondary_color', $invitation->secondary_color ?: '#fefcf8') }}" readonly
                                                    class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Zarf Yazı Rengi</label>
                                            <div class="flex gap-2 items-center">
                                                <input type="color" name="envelope_text_color" value="{{ old('envelope_text_color', $invitation->envelope_text_color ?: '#333333') }}"
                                                    class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ old('envelope_text_color', $invitation->envelope_text_color ?: '#333333') }}" readonly
                                                    class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Kapak Fotoğrafı</label>
                                        @if($invitation->cover_image)
                                            <div class="mb-3 rounded-xl overflow-hidden shadow-sm border border-cream-200 dark:border-night-700">
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}" class="w-full h-48 object-cover">
                                            </div>
                                        @endif
                                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                            <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📸</span>
                                            <span class="text-sm text-night-400 dark:text-cream-400 font-medium">Kapak fotoğrafı yükle</span>
                                            <span class="text-xs text-night-300 dark:text-night-500 mt-0.5">Önerilen: 1200x800px</span>
                                            <input type="file" name="cover_image" accept="image/*" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                        </label>
                                        @error('cover_image')
                                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end pt-6 mt-6 border-t border-cream-100 dark:border-night-700">
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 hover:-translate-y-0.5 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Tasarımı Kaydet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>

                <template x-if="tab === 'photos'">
                    <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🖼️</span>
                                <div>
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">Fotoğraf Galerisi</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">Özel anılarını davetlilerinle paylaş</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.images.upload', $invitation) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                                @csrf
                                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all mb-4 group">
                                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📤</span>
                                    <span class="text-sm text-night-400 dark:text-cream-400 font-medium">Fotoğraf yüklemek için tıkla</span>
                                    <input type="file" name="image" accept="image/*" class="hidden" required onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="caption" placeholder="Fotoğraf açıklaması"
                                        class="flex-1 px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                    <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm shrink-0">Yükle</button>
                                </div>
                            </form>
                            @if($invitation->images->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($invitation->images as $image)
                                        <div class="relative rounded-xl overflow-hidden bg-cream-50 dark:bg-night-900 aspect-square group shadow-sm border border-cream-100 dark:border-night-700">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                            <form action="{{ route('user.invitations.images.delete', $image) }}" method="POST" onsubmit="return confirm('Silmek istediğine emin misin?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="absolute top-2 right-2 w-8 h-8 rounded-full bg-black/50 text-white flex items-center justify-center text-sm opacity-0 group-hover:opacity-100 hover:bg-black/70 backdrop-blur-sm transition-all duration-200">
                                                    ✕
                                                </button>
                                            </form>
                                            @if($image->caption)
                                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                                    <span class="text-xs text-white">{{ $image->caption }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-14 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700">
                                    <span class="text-4xl block mb-3">🖼️</span>
                                    <p class="text-night-400 dark:text-cream-400 text-sm font-medium">Henüz fotoğraf eklenmemiş</p>
                                    <p class="text-xs text-night-300 dark:text-night-500 mt-1">Yukarıdan fotoğraf yükleyerek galerini oluştur</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </template>

                <template x-if="tab === 'music'">
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🎵</span>
                                    <div>
                                        <h2 class="font-bold text-night-900 dark:text-cream-100">Müzik</h2>
                                        <p class="text-xs text-night-400 dark:text-cream-400">Davetiyene fon müziği ekle</p>
                                    </div>
                                </div>
                            </div>
                            @if ($userPlan && !$userPlan->music_feature && !auth()->user()->is_admin)
                            <div class="mx-6 sm:mx-8 mb-6 p-4 rounded-xl bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20 flex items-start gap-3">
                                <span class="text-lg shrink-0">🔒</span>
                                <div>
                                    <p class="font-semibold text-gold-800 dark:text-gold-300 text-sm">Müzik özelliği paketine dahil değil</p>
                                    <p class="text-xs text-gold-700/70 dark:text-gold-400/70 mt-0.5">Planını yükselterek müzik özelliğini aktif edebilirsin.</p>
<a href="{{ $suggestedPlan ? route('payment.checkout', $suggestedPlan) : route('home') . '#pricing' }}" class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-gold-600 dark:text-gold-400 hover:text-gold-700 dark:hover:text-gold-300 transition-colors">
                                        Planını Yükselt
                                    </a>
                                </div>
                            </div>
                            @endif
                            <div class="px-6 sm:px-8 py-6 sm:py-8">
                                <form action="{{ route('user.invitations.music.upload', $invitation) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">Müzik Adı</label>
                                            <input type="text" name="title" placeholder="Düğün Şarkımız"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">YouTube / SoundCloud Linki</label>
                                            <input type="text" name="embed_url" placeholder="https://www.youtube.com/embed/..."
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            <p class="text-xs text-night-400 dark:text-cream-400 mt-1.5">YouTube embed linki yapıştır veya aşağıdan MP3 yükle</p>
                                        </div>
                                        <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                            <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">🎶</span>
                                            <span class="text-sm text-night-400 dark:text-cream-400 font-medium">MP3 dosyası yükle</span>
                                            <input type="file" name="music_file" accept="audio/*" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                        </label>
                                    </div>
                                    <div class="flex justify-end mt-5">
                                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Müzik Ekle
                                        </button>
                                    </div>
                                </form>
                                @if($invitation->music->count() > 0)
                                    <div class="mt-5 space-y-2.5">
                                        @foreach($invitation->music as $music)
                                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 hover:border-gold-200 dark:hover:border-gold-500/30 transition-all">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    <span class="text-lg shrink-0">🎵</span>
                                                    <span class="text-sm font-medium text-night-700 dark:text-cream-200 truncate">{{ $music->title ?: ($music->embed_url ? 'YouTube Müzik' : 'Ses Dosyası') }}</span>
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0 {{ $music->embed_url ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20' : 'bg-gold-50 text-gold-700 dark:bg-gold-500/10 dark:text-gold-400 border border-gold-200 dark:border-gold-500/20' }}">
                                                        {{ $music->embed_url ? 'Link' : 'Dosya' }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('user.invitations.music.delete', $music) }}" method="POST" onsubmit="return confirm('Silmek istediğine emin misin?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-600 transition-colors shrink-0 hover:bg-red-50 dark:hover:bg-red-500/10 px-2.5 py-1 rounded-lg">Sil</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700 mt-5">
                                        <span class="text-3xl block mb-2">🎵</span>
                                        <p class="text-night-400 dark:text-cream-400 text-sm font-medium">Henüz müzik eklenmemiş</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🎬</span>
                                    <div>
                                        <h2 class="font-bold text-night-900 dark:text-cream-100">Videolar</h2>
                                        <p class="text-xs text-night-400 dark:text-cream-400">YouTube videoları ekle</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 sm:px-8 py-6 sm:py-8">
                                <form action="{{ route('user.invitations.videos.add', $invitation) }}" method="POST">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">YouTube / Vimeo URL</label>
                                            <input type="url" name="url" placeholder="https://www.youtube.com/watch?v=..." required
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                        <div class="flex gap-2">
                                            <div class="relative">
                                                <select name="type"
                                                    class="w-32 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    <option value="youtube">YouTube</option>
                                                    <option value="vimeo">Vimeo</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </div>
                                            <input type="text" name="caption" placeholder="Video açıklaması"
                                                class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            <button type="submit" class="px-5 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm shrink-0 flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                <span class="hidden sm:inline">Ekle</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @if($invitation->videos->count() > 0)
                                    <div class="mt-5 space-y-2.5">
                                        @foreach($invitation->videos as $video)
                                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 hover:border-gold-200 dark:hover:border-gold-500/30 transition-all">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    <span class="text-lg shrink-0">🎬</span>
                                                    <span class="text-sm font-semibold text-gold-700 dark:text-gold-400 truncate">{{ $video->caption ?: 'Video' }}</span>
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20 shrink-0">{{ ucfirst($video->type) }}</span>
                                                </div>
                                                <form action="{{ route('user.invitations.videos.delete', $video) }}" method="POST" onsubmit="return confirm('Silmek istediğine emin misin?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-600 transition-colors shrink-0 hover:bg-red-50 dark:hover:bg-red-500/10 px-2.5 py-1 rounded-lg">Sil</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700 mt-5">
                                        <span class="text-3xl block mb-2">🎬</span>
                                        <p class="text-night-400 dark:text-cream-400 text-sm font-medium">Henüz video eklenmemiş</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden sticky top-32">
                    <div class="p-5 sm:p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold-100 to-gold-200 dark:from-gold-500/20 dark:to-gold-500/10 flex items-center justify-center text-sm">🔗</div>
                            <div>
                                <h4 class="font-bold text-night-900 dark:text-cream-100 text-sm">Davetiye Linki</h4>
                                <p class="text-xs text-night-400 dark:text-cream-400">QR kod ve önizleme</p>
                            </div>
                        </div>
                        @if($invitation->is_published)
                            <div class="bg-gold-50/50 dark:bg-gold-500/5 rounded-xl p-3.5 border border-gold-100/50 dark:border-gold-500/10 mb-4">
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-xs font-semibold text-gold-700 dark:text-gold-400 break-all hover:text-gold-800 transition-colors">
                                    {{ route('invitation.show', $invitation->slug) }}
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('user.invitations.qr', $invitation) }}"
                                    class="text-center py-2.5 rounded-xl text-sm font-semibold bg-gold-50 dark:bg-gold-500/10 text-gold-700 dark:text-gold-400 hover:bg-gold-100 dark:hover:bg-gold-500/20 border border-gold-200/50 dark:border-gold-500/20 transition-all">
                                    📱 QR Kod
                                </a>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-center py-2.5 rounded-xl text-sm font-semibold bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-300 hover:bg-cream-100 dark:hover:bg-night-700 border border-cream-200 dark:border-night-700 transition-all">
                                    👁️ Önizle
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700">
                                <span class="text-2xl block mb-2">🔗</span>
                                <p class="text-sm text-night-400 dark:text-cream-400">Yayınlandığında link ve QR kod görünecek</p>
                            </div>
                        @endif
                    </div>
                    <div class="border-t border-cream-100 dark:border-night-700">
                        <div class="p-5 sm:p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-500/20 dark:to-rose-500/10 flex items-center justify-center text-sm">📊</div>
                                <div>
                                    <h4 class="font-bold text-night-900 dark:text-cream-100 text-sm">İstatistikler</h4>
                                    <p class="text-xs text-night-400 dark:text-cream-400">Davetiye performansı</p>
                                </div>
                            </div>
                            <div class="space-y-0 divide-y divide-cream-100 dark:divide-night-700">
                                <div class="flex items-center justify-between py-3 first:pt-0">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>👁️</span> Görüntülenme</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->views }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>📱</span> QR Tarama</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->qr_scans }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>💌</span> RSVP</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->rsvps_count ?? $invitation->rsvps()->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pat-prev- { background: white; }
        .dark .pat-prev- { background: #3d4353; }
        .pat-prev-lace { background-image: repeating-linear-gradient(45deg,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px,transparent 8px),repeating-linear-gradient(-45deg,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px,transparent 8px); background-size: 10px 10px; }
        .pat-prev-floral { background-image: radial-gradient(circle at 25% 30%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 2.5px,transparent 2.5px),radial-gradient(circle at 75% 70%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 2.5px,transparent 2.5px); background-size: 24px 24px,24px 24px; }
        .pat-prev-geometric { background-image: repeating-linear-gradient(0deg,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 1.5px,transparent 1.5px,transparent 12px),repeating-linear-gradient(90deg,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 1.5px,transparent 1.5px,transparent 12px); background-size: 12px 12px,12px 12px; }
        .pat-prev-stars { background-image: radial-gradient(circle at 20% 25%,rgba(0,0,0,0.25) 0,rgba(0,0,0,0.25) 2px,transparent 2px),radial-gradient(circle at 80% 30%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 50% 80%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 2px,transparent 2px); background-size: 32px 32px,32px 32px,32px 32px; }
        .pat-prev-hearts { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='black' opacity='0.18' d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/%3E%3C/svg%3E"); background-size: 22px 22px; }
        .pat-prev-damask { background-image: repeating-conic-gradient(rgba(0,0,0,0.15) 0% 25%,transparent 0% 50%); background-size: 18px 18px; }
        .pat-prev-minimal { background-image: repeating-linear-gradient(90deg,rgba(0,0,0,0.22) 0,rgba(0,0,0,0.22) 1.5px,transparent 1.5px,transparent 12px); background-size: 12px 12px; }
        .pat-prev-leaf { background-image: repeating-linear-gradient(12deg,transparent 0,transparent 8px,rgba(0,0,0,0.18) 8px,rgba(0,0,0,0.18) 9.5px,transparent 9.5px,transparent 18px),linear-gradient(90deg,transparent 45%,rgba(0,0,0,0.25) 45%,rgba(0,0,0,0.25) 55%,transparent 55%); }
        .pat-prev-vine { background-image: repeating-linear-gradient(50deg,transparent 0,transparent 12px,rgba(0,0,0,0.18) 12px,rgba(0,0,0,0.18) 14.5px,transparent 14.5px,transparent 26px),repeating-linear-gradient(-50deg,transparent 0,transparent 8px,rgba(0,0,0,0.12) 8px,rgba(0,0,0,0.12) 9.5px,transparent 9.5px,transparent 22px); }
        .pat-prev-blossom { background-image: radial-gradient(circle at 15% 25%,rgba(0,0,0,0.25) 0,rgba(0,0,0,0.25) 2px,transparent 2px),radial-gradient(circle at 10% 30%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 20% 30%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 15% 34%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 55% 65%,rgba(0,0,0,0.25) 0,rgba(0,0,0,0.25) 2px,transparent 2px),radial-gradient(circle at 50% 70%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 60% 70%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px),radial-gradient(circle at 55% 74%,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px); background-size: 36px 36px,36px 36px,36px 36px,36px 36px,36px 36px,36px 36px,36px 36px,36px 36px; }
        .pat-prev-botanic { background-image: repeating-linear-gradient(0deg,rgba(0,0,0,0.12) 0,rgba(0,0,0,0.12) 0.5px,transparent 0.5px,transparent 6px),repeating-linear-gradient(90deg,rgba(0,0,0,0.12) 0,rgba(0,0,0,0.12) 0.5px,transparent 0.5px,transparent 6px),radial-gradient(circle at 25% 25%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 1px,transparent 1px),radial-gradient(circle at 75% 75%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 1px,transparent 1px); background-size: 12px 12px,12px 12px,12px 12px,12px 12px; }
        .pat-prev-fern { background-image: repeating-linear-gradient(30deg,rgba(0,0,0,0.18) 0,rgba(0,0,0,0.18) 1.5px,transparent 1.5px,transparent 12px),repeating-linear-gradient(-30deg,rgba(0,0,0,0.12) 0,rgba(0,0,0,0.12) 1px,transparent 1px,transparent 12px),linear-gradient(90deg,transparent 45%,rgba(0,0,0,0.22) 45%,rgba(0,0,0,0.22) 55%,transparent 55%); }
        .pat-prev-petal { background-image: radial-gradient(circle at 20% 20%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 5px,transparent 5px),radial-gradient(circle at 50% 20%,rgba(0,0,0,0.15) 0,rgba(0,0,0,0.15) 4px,transparent 4px),radial-gradient(circle at 80% 20%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 5px,transparent 5px),radial-gradient(circle at 35% 50%,rgba(0,0,0,0.15) 0,rgba(0,0,0,0.15) 4px,transparent 4px),radial-gradient(circle at 65% 50%,rgba(0,0,0,0.15) 0,rgba(0,0,0,0.15) 4px,transparent 4px),radial-gradient(circle at 20% 80%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 5px,transparent 5px),radial-gradient(circle at 50% 80%,rgba(0,0,0,0.15) 0,rgba(0,0,0,0.15) 4px,transparent 4px),radial-gradient(circle at 80% 80%,rgba(0,0,0,0.2) 0,rgba(0,0,0,0.2) 5px,transparent 5px); background-size: 40px 40px,40px 40px,40px 40px,40px 40px,40px 40px,40px 40px,40px 40px,40px 40px; }
    </style>

    <script>
        window.envPatterns = [
            {v:'', l:'Yok'},
            {v:'lace', l:'Dantel'},
            {v:'floral', l:'Çiçek'},
            {v:'geometric', l:'Geometrik'},
            {v:'stars', l:'Yıldız'},
            {v:'hearts', l:'Kalp'},
            {v:'damask', l:'Damask'},
            {v:'minimal', l:'Minimal'},
            {v:'leaf', l:'Yaprak'},
            {v:'vine', l:'Sarmaşık'},
            {v:'blossom', l:'Çiçek Kümesi'},
            {v:'botanic', l:'Botanik'},
            {v:'fern', l:'Eğrelti'},
            {v:'petal', l:'Taç Yaprağı'},
        ];

        window.themes = @json($themes);

        var editEventLabels = {
            wedding: {
                groomLabel: '👨 Damat Ad\u0131', groomPlaceholder: 'Ahmet',
                brideLabel: '\ud83d\udc70 Gelin Ad\u0131', bridePlaceholder: 'Ay\u015fe',
                groomParentTitle: 'Damat Ailesi',
                brideParentTitle: 'Gelin Ailesi',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Mehmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: 'Baba Ad\u0131', brideFatherPlaceholder: 'Ahmet',
                brideMotherLabel: 'Anne Ad\u0131', brideMotherPlaceholder: 'Fatma',
                showBride: true, showBrideParents: true, showGroomMother: true, showBrideFather: true, showBrideMother: true, titleHint: 'D\u00fc\u011f\u00fcn Davetiyesi'
            },
            engagement: {
                groomLabel: '👨 Damat Ad\u0131', groomPlaceholder: 'Ahmet',
                brideLabel: '\ud83d\udc70 Gelin Ad\u0131', bridePlaceholder: 'Ay\u015fe',
                groomParentTitle: 'Erkek Ailesi',
                brideParentTitle: 'K\u0131z Ailesi',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Mehmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: 'Baba Ad\u0131', brideFatherPlaceholder: 'Ahmet',
                brideMotherLabel: 'Anne Ad\u0131', brideMotherPlaceholder: 'Fatma',
                showBride: true, showBrideParents: true, showGroomMother: true, showBrideFather: true, showBrideMother: true, titleHint: 'Ni\u015fan Davetiyesi'
            },
            circumcision: {
                groomLabel: '\u2702\ufe0f \u00c7ocuk Ad\u0131', groomPlaceholder: 'Mehmet',
                brideLabel: '', bridePlaceholder: '',
                groomParentTitle: 'Aile Bilgileri',
                brideParentTitle: '',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Ahmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: '', brideFatherPlaceholder: '',
                brideMotherLabel: '', brideMotherPlaceholder: '',
                showBride: false, showBrideParents: false, showGroomMother: true, showBrideFather: false, showBrideMother: false, titleHint: 'S\u00fcnnet Davetiyesi'
            },
            birthday: {
                groomLabel: '\ud83c\udf82 Do\u011fum G\u00fcn\u00fc Ki\u015fisi', groomPlaceholder: 'Ay\u015fe',
                brideLabel: 'Ya\u015f', bridePlaceholder: '25',
                groomParentTitle: 'Aile Bilgileri',
                brideParentTitle: '',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Ahmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: '', brideFatherPlaceholder: '',
                brideMotherLabel: '', brideMotherPlaceholder: '',
                showBride: true, showBrideParents: false, showGroomMother: true, showBrideFather: false, showBrideMother: false, titleHint: 'Do\u011fum G\u00fcn\u00fc Davetiyesi'
            },
            corporate: {
                groomLabel: '\ud83c\udfe2 \u015eirket Ad\u0131', groomPlaceholder: 'ACME \u015eirketi',
                brideLabel: '\u0130leti\u015fim Ki\u015fisi', bridePlaceholder: 'Ahmet Y\u0131lmaz',
                groomParentTitle: 'Adres',
                brideParentTitle: '',
                groomFatherLabel: 'Adres', groomFatherPlaceholder: 'Mecidiyek\u00f6y, \u0130stanbul',
                groomMotherLabel: '', groomMotherPlaceholder: '',
                brideFatherLabel: '', brideFatherPlaceholder: '',
                brideMotherLabel: '', brideMotherPlaceholder: '',
                showBride: true, showBrideParents: false, showGroomMother: false, showBrideFather: false, showBrideMother: false, titleHint: 'Kurumsal Davetiye'
            }
        };

        function updateEditEventFields(type) {
            var l = editEventLabels[type] || editEventLabels.wedding;
            var set = function(id, val) { var el = document.getElementById(id); if (el) el.innerHTML = val; };
            var setPl = function(id, val) { var el = document.getElementById(id); if (el) el.placeholder = val; };
            var show = function(id, vis) { var el = document.getElementById(id); if (el) el.style.display = vis ? '' : 'none'; };

            set('editGroomLabel', l.groomLabel);
            setPl('editGroomInput', l.groomPlaceholder);
            set('editBrideLabel', l.brideLabel);
            setPl('editBrideInput', l.bridePlaceholder);
            set('editGroomParentTitle', l.groomParentTitle);
            set('editBrideParentTitle', l.brideParentTitle);
            set('editGroomFatherLabel', l.groomFatherLabel);
            set('editGroomMotherLabel', l.groomMotherLabel || ' ');
            set('editBrideFatherLabel', l.brideFatherLabel || ' ');
            set('editBrideMotherLabel', l.brideMotherLabel || ' ');

            show('editBrideField', l.showBride);
            show('editBrideParents', l.showBrideParents);
            show('editGroomMotherField', l.showGroomMother);
            show('editBrideFatherField', l.showBrideFather);
            show('editBrideMotherField', l.showBrideMother);

            var gf = document.querySelector('input[name="groom_father"]');
            if (gf) gf.placeholder = l.groomFatherPlaceholder;

            var bi = document.getElementById('editBrideInput');
            if (bi) bi.required = l.showBride;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var sel = document.getElementById('editEventTypeSelect');
            if (sel) {
                updateEditEventFields(sel.value);
                sel.addEventListener('change', function() { updateEditEventFields(this.value); });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var themeSelect = document.querySelector('select[name="theme"]');
            if (!themeSelect) return;
            themeSelect.addEventListener('change', function() {
                var slug = this.value;
                var theme = window.themes.find(function(t) { return t.slug === slug; });
                if (!theme) return;

                var primaryInput = document.querySelector('input[name="primary_color"]');
                var secondaryInput = document.querySelector('input[name="secondary_color"]');
                var fontSelect = document.querySelector('select[name="font_family"]');

                if (primaryInput && theme.primary_color) {
                    primaryInput.value = theme.primary_color;
                    var next = primaryInput.nextElementSibling;
                    if (next) next.value = theme.primary_color;
                }
                if (secondaryInput && theme.secondary_color) {
                    secondaryInput.value = theme.secondary_color;
                    var next = secondaryInput.nextElementSibling;
                    if (next) next.value = theme.secondary_color;
                }
                if (fontSelect && theme.font_family) {
                    fontSelect.value = theme.font_family;
                }
            });
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-start sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-gold-400 to-rose-500 flex items-center justify-center text-white font-bold shadow-lg shrink-0">
                        {{ substr($invitation->groom_name ?: 'D', 0, 1) }}{{ substr($invitation->bride_name ?: 'V', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-xl font-bold text-night-900 dark:text-cream-100 truncate">{{ $invitation->title ?: __('Yeni Davetiye') }}</h1>
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
                            {{ __('Yayından Kaldır') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('user.invitations.publish', $invitation) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-500/20 transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Yayınla') }}
                        </button>
                    </form>
                @endif
                <a href="{{ route('user.invitations.preview', $invitation) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-night-800 text-night-500 dark:text-cream-300 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ __('Önizle') }}
                </a>
                <a href="{{ route('user.invitations.show', $invitation) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-night-800 text-night-500 dark:text-cream-300 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    {{ __('İstatistikler') }}
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
                <span>{{ __('Bilgiler') }}</span>
            </button>
            <button @click="tab = 'design'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'design' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🎨</span>
                <span>{{ __('Tasarım') }}</span>
            </button>
            <button @click="tab = 'photos'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'photos' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🖼️</span>
                <span>{{ __('Fotoğraflar') }}</span>
            </button>
            <button @click="tab = 'music'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap flex items-center gap-2"
                :class="tab === 'music' ? 'bg-gradient-to-r from-gold-50 to-rose-50 dark:from-gold-500/10 dark:to-rose-500/10 text-gold-700 dark:text-gold-400 shadow-sm' : 'text-night-400 dark:text-cream-400 hover:text-night-700 dark:hover:text-cream-200 hover:bg-cream-50 dark:hover:bg-night-700/50'">
                <span class="text-base">🎵</span>
                <span>{{ __('Müzik & Video') }}</span>
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
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Davetiye Bilgileri') }}</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Çift ve etkinlik bilgilerini gir') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.update', $invitation) }}" method="POST">
                                @csrf @method('PUT')
                                @php
                                    $etype = old('event_type', $invitation->event_type) ?: 'wedding';
                                    $elabels = [
                                        'wedding' => ['groomLabel'=>'👨 Damat Adı','groomPlaceholder'=>'Ahmet','brideLabel'=>'👰 Gelin Adı','bridePlaceholder'=>'Ayşe','groomParentTitle'=>'Damat Ailesi','brideParentTitle'=>'Gelin Ailesi','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Mehmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'Baba Adı','brideFatherPlaceholder'=>'Ahmet','brideMotherLabel'=>'Anne Adı','brideMotherPlaceholder'=>'Fatma','showBride'=>true,'showBrideParents'=>true,'showStory'=>true,'titleHint'=>'Düğün Davetiyesi'],
                                        'engagement' => ['groomLabel'=>'👨 Damat Adı','groomPlaceholder'=>'Ahmet','brideLabel'=>'👰 Gelin Adı','bridePlaceholder'=>'Ayşe','groomParentTitle'=>'Erkek Ailesi','brideParentTitle'=>'Kız Ailesi','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Mehmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'Baba Adı','brideFatherPlaceholder'=>'Ahmet','brideMotherLabel'=>'Anne Adı','brideMotherPlaceholder'=>'Fatma','showBride'=>true,'showBrideParents'=>true,'showStory'=>true,'titleHint'=>'Nişan Davetiyesi'],
                                        'circumcision' => ['groomLabel'=>'✂️ Çocuk Adı','groomPlaceholder'=>'Mehmet','brideLabel'=>'','bridePlaceholder'=>'','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>false,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Sünnet Davetiyesi'],
                                        'birthday' => ['groomLabel'=>'🎂 Doğum Günü Kişisi','groomPlaceholder'=>'Ayşe','brideLabel'=>'Yaş','bridePlaceholder'=>'25','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>true,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Doğum Günü Davetiyesi'],
                                        'corporate' => ['groomLabel'=>'🏢 Şirket Adı','groomPlaceholder'=>'ACME Şirketi','brideLabel'=>'İletişim Kişisi','bridePlaceholder'=>'Ahmet Yılmaz','groomParentTitle'=>'Adres','brideParentTitle'=>'','groomFatherLabel'=>'Adres','groomFatherPlaceholder'=>'Mecidiyeköy, İstanbul','groomMotherLabel'=>'','groomMotherPlaceholder'=>'','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>true,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Kurumsal Davetiye'],
                                        'graduation' => ['groomLabel'=>'🎓 Mezun Olan Kişi','groomPlaceholder'=>'Ali','brideLabel'=>'','bridePlaceholder'=>'','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>false,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Mezuniyet Davetiyesi'],
                                    ];
                                    $el = $elabels[$etype] ?? $elabels['wedding'];
                                @endphp
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('🎪 Etkinlik Türü') }}</label>
                                        <div class="relative">
                                            <select name="event_type" id="editEventTypeSelect"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                <option value="wedding" {{ ($invitation->event_type ?: 'wedding') === 'wedding' ? 'selected' : '' }}>{{ __('💍 Düğün') }}</option>
                                                <option value="engagement" {{ ($invitation->event_type ?: 'wedding') === 'engagement' ? 'selected' : '' }}>{{ __('💍 Nişan') }}</option>
                                                <option value="circumcision" {{ ($invitation->event_type ?: 'wedding') === 'circumcision' ? 'selected' : '' }}>{{ __('✂️ Sünnet') }}</option>
                                                <option value="birthday" {{ ($invitation->event_type ?: 'wedding') === 'birthday' ? 'selected' : '' }}>{{ __('🎂 Doğum Günü') }}</option>
                                                <option value="corporate" {{ ($invitation->event_type ?: 'wedding') === 'corporate' ? 'selected' : '' }}>{{ __('🏢 Kurumsal') }}</option>
                                                <option value="graduation" {{ ($invitation->event_type ?: 'wedding') === 'graduation' ? 'selected' : '' }}>{{ __('🎓 Mezuniyet') }}</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="editCoupleFields">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                            <div>
                                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="editGroomLabel">{{ $el['groomLabel'] }}</label>
                                                <input type="text" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="editGroomInput" placeholder="{{ $el['groomPlaceholder'] }}">
                                            </div>
                                            <div id="editBrideField" @if(!$el['showBride']) style="display:none" @endif>
                                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="editBrideLabel">{{ $el['brideLabel'] }}</label>
                                                <input type="text" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" @if($el['showBride']) required @endif
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="editBrideInput" placeholder="{{ $el['bridePlaceholder'] }}">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mt-4 sm:mt-5" id="editGroomParents">
                                            <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700">
                                                <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                    <span>👪</span> <span id="editGroomParentTitle">{{ $el['groomParentTitle'] }}</span>
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editGroomFatherLabel">{{ $el['groomFatherLabel'] }}</label>
                                                        <input type="text" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" placeholder="{{ $el['groomFatherPlaceholder'] }}"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                    <div id="editGroomMotherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editGroomMotherLabel">{{ $el['groomMotherLabel'] }}</label>
                                                        <input type="text" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" placeholder="{{ $el['groomMotherPlaceholder'] }}"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700" id="editBrideParents" @if(!$el['showBrideParents']) style="display:none" @endif>
                                                <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                    <span>👪</span> <span id="editBrideParentTitle">{{ $el['brideParentTitle'] }}</span>
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div id="editBrideFatherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editBrideFatherLabel">{{ $el['brideFatherLabel'] }}</label>
                                                        <input type="text" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" placeholder="{{ $el['brideFatherPlaceholder'] }}"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                    <div id="editBrideMotherField">
                                                        <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="editBrideMotherLabel">{{ $el['brideMotherLabel'] }}</label>
                                                        <input type="text" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" placeholder="{{ $el['brideMotherPlaceholder'] }}"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Başlık') }}</label>
                                        <input type="text" name="title" value="{{ old('title', $invitation->title) }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" placeholder="{{ $el['titleHint'] }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('🔗 Kısa Link') }}</label>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-sm text-night-400 dark:text-cream-400 shrink-0">{{ url('/s/') }}</span>
                                            <input type="text" name="short_link" value="{{ old('short_link', $invitation->short_link) }}"
                                                class="flex-1 w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all font-mono" placeholder="ozel-davetiyem-2025" pattern="[a-z0-9-]+">
                                        </div>
                                        <p class="text-xs text-night-400 dark:text-cream-400 mt-1.5">{{ __('Sadece küçük harf, rakam ve tire kullanın. Paylaşım linkiniz kısalır.') }}</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📅 Tarih') }}</label>
                                            <div class="relative">
                                                <input type="date" name="event_date" value="{{ old('event_date', $invitation->event_date?->format('Y-m-d')) }}"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('⏰ Saat') }}</label>
                                            <input type="time" name="event_time" value="{{ old('event_time', $invitation->event_time) }}"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📍 Adres') }}</label>
                                        <textarea name="event_address" rows="2"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('event_address', $invitation->event_address) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('💬 Karşılama Mesajı') }}</label>
                                        <textarea name="welcome_message" rows="3"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('welcome_message', $invitation->welcome_message) }}</textarea>
                                    </div>

                                    <div id="editStoryField" @if(!$el['showStory']) style="display:none" @endif>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('💕 Hikayeniz') }}</label>
                                        <textarea name="story" rows="4"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('story', $invitation->story) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📝 Özel Not') }}</label>
                                        <textarea name="special_note" rows="2"
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none">{{ old('special_note', $invitation->special_note) }}</textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-6 mt-6 border-t border-cream-100 dark:border-night-700">
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 hover:-translate-y-0.5 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ __('Bilgileri Kaydet') }}
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
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Tema ve Tasarım') }}</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Davetiyenin görünümünü özelleştir') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.update', $invitation) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                @if($errors->any())
                                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 mb-4">
                                        <p class="text-sm font-semibold text-red-600 dark:text-red-400">{{ __('Hata oluştu. Lütfen hataları düzeltip tekrar kaydedin.') }}</p>
                                    </div>
                                @endif
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Tema') }}</label>
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
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Animasyonu') }}</label>
                                            <div class="relative">
                                                <select name="envelope_animation"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    <option value="classic" {{ $invitation->envelope_animation === 'classic' ? 'selected' : '' }}>{{ __('Klasik (Zarf Açılır)') }}</option>
                                                    <option value="heart" {{ $invitation->envelope_animation === 'heart' ? 'selected' : '' }}>{{ __('Kalp Patlaması') }}</option>
                                                    <option value="magic" {{ $invitation->envelope_animation === 'magic' ? 'selected' : '' }}>{{ __('Sihirli Işıltı') }}</option>
                                                    <option value="flip" {{ $invitation->envelope_animation === 'flip' ? 'selected' : '' }}>{{ __('3D Dönüş') }}</option>
                                                    <option value="ripple" {{ $invitation->envelope_animation === 'ripple' ? 'selected' : '' }}>{{ __('Dalga Efekti') }}</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Yazı Tipi') }}</label>
                                            <div class="relative">
                                                <select name="font_family"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                                    <optgroup label="{{ __('Lüks ve Premium') }}">
                                                        <option value="Cinzel" {{ $invitation->font_family === 'Cinzel' ? 'selected' : '' }}>Cinzel</option>
                                                        <option value="Cormorant Garamond" {{ $invitation->font_family === 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond</option>
                                                        <option value="Playfair Display" {{ $invitation->font_family === 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                                                        <option value="Bodoni Moda" {{ $invitation->font_family === 'Bodoni Moda' ? 'selected' : '' }}>Bodoni Moda</option>
                                                        <option value="DM Serif Display" {{ $invitation->font_family === 'DM Serif Display' ? 'selected' : '' }}>DM Serif Display</option>
                                                    </optgroup>
                                                    <optgroup label="{{ __('Modern ve Temiz') }}">
                                                        <option value="Montserrat" {{ $invitation->font_family === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                                        <option value="Poppins" {{ $invitation->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                                                        <option value="Inter" {{ $invitation->font_family === 'Inter' ? 'selected' : '' }}>Inter</option>
                                                        <option value="Manrope" {{ $invitation->font_family === 'Manrope' ? 'selected' : '' }}>Manrope</option>
                                                        <option value="Outfit" {{ $invitation->font_family === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                                                        <option value="Plus Jakarta Sans" {{ $invitation->font_family === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans</option>
                                                    </optgroup>
                                                    <optgroup label="{{ __('Teknoloji ve Yazılım') }}">
                                                        <option value="Space Grotesk" {{ $invitation->font_family === 'Space Grotesk' ? 'selected' : '' }}>Space Grotesk</option>
                                                        <option value="Sora" {{ $invitation->font_family === 'Sora' ? 'selected' : '' }}>Sora</option>
                                                        <option value="Exo 2" {{ $invitation->font_family === 'Exo 2' ? 'selected' : '' }}>Exo 2</option>
                                                        <option value="Orbitron" {{ $invitation->font_family === 'Orbitron' ? 'selected' : '' }}>Orbitron</option>
                                                        <option value="Rajdhani" {{ $invitation->font_family === 'Rajdhani' ? 'selected' : '' }}>Rajdhani</option>
                                                    </optgroup>
                                                    <optgroup label="{{ __('Kalın ve Dikkat Çekici') }}">
                                                        <option value="Bebas Neue" {{ $invitation->font_family === 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue</option>
                                                        <option value="Anton" {{ $invitation->font_family === 'Anton' ? 'selected' : '' }}>Anton</option>
                                                        <option value="League Spartan" {{ $invitation->font_family === 'League Spartan' ? 'selected' : '' }}>League Spartan</option>
                                                        <option value="Oswald" {{ $invitation->font_family === 'Oswald' ? 'selected' : '' }}>Oswald</option>
                                                        <option value="Teko" {{ $invitation->font_family === 'Teko' ? 'selected' : '' }}>Teko</option>
                                                    </optgroup>
                                                    <optgroup label="{{ __('İmza ve Şık Yazılar') }}">
                                                        <option value="Great Vibes" {{ $invitation->font_family === 'Great Vibes' ? 'selected' : '' }}>Great Vibes</option>
                                                        <option value="Allura" {{ $invitation->font_family === 'Allura' ? 'selected' : '' }}>Allura</option>
                                                        <option value="Parisienne" {{ $invitation->font_family === 'Parisienne' ? 'selected' : '' }}>Parisienne</option>
                                                        <option value="Alex Brush" {{ $invitation->font_family === 'Alex Brush' ? 'selected' : '' }}>Alex Brush</option>
                                                        <option value="Brittany Signature" {{ $invitation->font_family === 'Brittany Signature' ? 'selected' : '' }}>Brittany Signature</option>
                                                        <option value="Anydore" {{ $invitation->font_family === 'Anydore' ? 'selected' : '' }}>Anydore</option>
                                                    </optgroup>
                                                    <optgroup label="{{ __('Diğer') }}">
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

                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-3">{{ __('Kendi Desenini Yükle') }}</label>

                                        <div class="rounded-xl border-2 border-dashed border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 transition-all duration-200 overflow-hidden">
                                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                                <div class="w-10 h-10 rounded-lg bg-cream-100 dark:bg-night-700 flex items-center justify-center text-lg shrink-0 border border-cream-200 dark:border-night-600">
                                                    <span>🖼️</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <span class="text-sm font-semibold text-night-700 dark:text-cream-200 block leading-tight">{{ __("PNG, JPG, SVG — 64MB'a kadar") }}</span>
                                                    <span class="text-xs text-night-400 dark:text-cream-400 block mt-0.5" id="editCustomFileLabel">{{ __('Dosya seçilmedi') }}</span>
                                                </div>
                                                <div class="px-3 py-1.5 rounded-lg text-xs font-semibold text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20 hover:bg-gold-100 dark:hover:bg-gold-500/20 transition-colors shrink-0">
                                                    {{ __('Gözat') }}
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
                                                    <span class="text-xs text-night-400 dark:text-cream-400 truncate">{{ __('Mevcut desen') }}</span>
                                                </div>
                                            @endif
                                            @error('custom_pattern')
                                                <p class="text-xs text-red-500 mt-1.5 px-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Ana Renk') }}</label>
                                            <div class="flex gap-2 items-center">
                                                <input type="color" name="primary_color" value="{{ old('primary_color', $invitation->primary_color ?: '#d4a61e') }}"
                                                    class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ old('primary_color', $invitation->primary_color ?: '#d4a61e') }}" readonly
                                                    class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Arka Plan') }}</label>
                                            <div class="flex gap-2 items-center">
                                                <input type="color" name="secondary_color" value="{{ old('secondary_color', $invitation->secondary_color ?: '#fefcf8') }}"
                                                    class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ old('secondary_color', $invitation->secondary_color ?: '#fefcf8') }}" readonly
                                                    class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Yazı Rengi') }}</label>
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
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Kapak Fotoğrafı') }}</label>
                                        @if($invitation->cover_image)
                                            <div class="mb-3 rounded-xl overflow-hidden shadow-sm border border-cream-200 dark:border-night-700 relative group">
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($invitation->cover_image) }}" class="w-full h-48 object-cover">
                                                <form action="{{ route('user.invitations.cover-image.delete', $invitation) }}" method="POST" onsubmit="return confirm('{{ __("Kapak fotoğrafını silmek istediğine emin misin?") }}')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-white/90 hover:bg-red-500 hover:text-white rounded-lg shadow-sm transition-all text-red-500">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                            <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📸</span>
                                            <span class="text-sm text-night-400 dark:text-cream-400 font-medium">{{ __('Kapak fotoğrafı yükle') }}</span>
                                            <span class="text-xs text-night-300 dark:text-night-500 mt-0.5">{{ __('Önerilen: 1200x800px') }}</span>
                                            <input type="file" name="cover_image" accept="image/*" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                        </label>
                                        @error('cover_image')
                                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @if(auth()->user()->plan?->cover_video_feature)
                                        @php
                                            $cv = $invitation->cover_video;
                                            $cvIsUrl = $cv && str_starts_with($cv, 'http');
                                            $cvEmbedUrl = '';
                                            if ($cvIsUrl && preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $cv, $m)) {
                                                $cvEmbedUrl = 'https://www.youtube-nocookie.com/embed/'.$m[1];
                                            }
                                        @endphp
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Kapak Videosu (Premium)') }}</label>
                                            @if($cv)
                                                <div class="mb-3 rounded-xl overflow-hidden shadow-sm border border-cream-200 dark:border-night-700 bg-black/5 relative group">
                                                    @if($cvEmbedUrl)
                                                        <div style="position:relative;padding-bottom:56.25%;height:0;">
                                                            <iframe src="{{ $cvEmbedUrl }}" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allowfullscreen></iframe>
                                                        </div>
                                                    @else
                                                        <video class="w-full h-48 object-cover" muted loop preload="metadata">
                                                            <source src="{{ \Illuminate\Support\Facades\Storage::url($cv) }}" type="{{ str_ends_with($cv, '.webm') ? 'video/webm' : (str_ends_with($cv, '.mov') ? 'video/quicktime' : 'video/mp4') }}">
                                                        </video>
                                                    @endif
                                                    <form action="{{ route('user.invitations.cover-video.delete', $invitation) }}" method="POST" onsubmit="return confirm('{{ __("Kapak videosunu silmek istediğine emin misin?") }}')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-white/90 hover:bg-red-500 hover:text-white rounded-lg shadow-sm transition-all text-red-500">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            <div class="space-y-4">
                                                <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🎬</span>
                                                    <span class="text-sm text-night-400 dark:text-cream-400 font-medium">{{ __('Kapak videosu yükle') }}</span>
                                                    <span class="text-xs text-night-300 dark:text-night-500 mt-0.5">{{ __('MP4, WebM, MOV - maks. 100MB') }}</span>
                                                    <input type="file" name="cover_video_file" accept="video/mp4,video/webm,video/quicktime" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                                </label>
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-1 h-px bg-cream-200 dark:border-night-700"></div>
                                                    <span class="text-xs font-semibold text-night-300 dark:text-cream-500">{{ __('VEYA') }}</span>
                                                    <div class="flex-1 h-px bg-cream-200 dark:border-night-700"></div>
                                                </div>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                                        <span class="text-lg">🔗</span>
                                                    </div>
                                                    <input type="url" name="cover_video_url" value="{{ $cvIsUrl ? $cv : '' }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-700 dark:text-cream-200 placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-200/50 dark:focus:ring-gold-500/20 outline-none transition-all text-sm">
                                                </div>
                                                <p class="text-xs text-night-300 dark:text-night-500 text-center -mt-1">{{ __('YouTube video linkini yapıştır, otomatik olarak kapak videon olarak gösterilsin') }}</p>
                                            </div>
                                            @error('cover_video_file')
                                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                            @error('cover_video_url')
                                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                </div>

                                <div class="flex justify-end pt-6 mt-6 border-t border-cream-100 dark:border-night-700">
                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 hover:-translate-y-0.5 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ __('Tasarımı Kaydet') }}
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
                                    <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Fotoğraf Galerisi') }}</h2>
                                    <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Özel anılarını davetlilerinle paylaş') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 sm:px-8 py-6 sm:py-8">
                            <form action="{{ route('user.invitations.images.upload', $invitation) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                                @csrf
                                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all mb-4 group">
                                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📤</span>
                                    <span class="text-sm text-night-400 dark:text-cream-400 font-medium">{{ __('Fotoğraf yüklemek için tıkla') }}</span>
                                    <input type="file" name="image" accept="image/*" class="hidden" required onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                </label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input type="text" name="caption" placeholder="{{ __('Fotoğraf açıklaması') }}"
                                        class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm shrink-0">{{ __('Yükle') }}</button>
                                </div>
                            </form>
                            @if($invitation->images->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($invitation->images as $image)
                                        <div class="relative rounded-xl overflow-hidden bg-cream-50 dark:bg-night-900 aspect-square group shadow-sm border border-cream-100 dark:border-night-700">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                            <form action="{{ route('user.invitations.images.delete', $image) }}" method="POST" onsubmit="return confirm('{{ __("Silmek istediğine emin misin?") }}')">
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
                                    <p class="text-night-400 dark:text-cream-400 text-sm font-medium">{{ __('Henüz fotoğraf eklenmemiş') }}</p>
                                    <p class="text-xs text-night-300 dark:text-night-500 mt-1">{{ __('Yukarıdan fotoğraf yükleyerek galerini oluştur') }}</p>
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
                                        <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Müzik') }}</h2>
                                        <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Davetiyene fon müziği ekle') }}</p>
                                    </div>
                                </div>
                            </div>
                            @if ($userPlan && !$userPlan->music_feature && !auth()->user()->is_admin)
                            <div class="mx-6 sm:mx-8 mb-6 p-4 rounded-xl bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20 flex items-start gap-3">
                                <span class="text-lg shrink-0">🔒</span>
                                <div>
                                    <p class="font-semibold text-gold-800 dark:text-gold-300 text-sm">{{ __('Müzik özelliği paketine dahil değil') }}</p>
                                    <p class="text-xs text-gold-700/70 dark:text-gold-400/70 mt-0.5">{{ __('Planını yükselterek müzik özelliğini aktif edebilirsin.') }}</p>
<a href="{{ $suggestedPlan ? route('payment.checkout', $suggestedPlan) : route('home') . '#pricing' }}" class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-gold-600 dark:text-gold-400 hover:text-gold-700 dark:hover:text-gold-300 transition-colors">
                                        {{ __('Planını Yükselt') }}
                                    </a>
                                </div>
                            </div>
                            @endif
                            <div class="px-6 sm:px-8 py-6 sm:py-8">
                                <form action="{{ route('user.invitations.music.upload', $invitation) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Müzik Adı') }}</label>
                                            <input type="text" name="title" placeholder="{{ __('Düğün Şarkımız') }}"
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('YouTube / SoundCloud Linki') }}</label>
                                            <input type="text" name="embed_url" placeholder="https://www.youtube.com/embed/..."
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            <p class="text-xs text-night-400 dark:text-cream-400 mt-1.5">{{ __('YouTube embed linki yapıştır veya aşağıdan MP3 yükle') }}</p>
                                        </div>
                                        <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                            <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">🎶</span>
                                            <span class="text-sm text-night-400 dark:text-cream-400 font-medium">{{ __('MP3 dosyası yükle') }}</span>
                                            <input type="file" name="music_file" accept="audio/*" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                        </label>
                                    </div>
                                    <div class="flex justify-end mt-5">
                                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            {{ __('Müzik Ekle') }}
                                        </button>
                                    </div>
                                </form>
                                @if($invitation->music->count() > 0)
                                    <div class="mt-5 space-y-2.5">
                                        @foreach($invitation->music as $music)
                                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-cream-50 dark:bg-night-900/50 border border-cream-100 dark:border-night-700 hover:border-gold-200 dark:hover:border-gold-500/30 transition-all">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    <span class="text-lg shrink-0">🎵</span>
                                                    <span class="text-sm font-medium text-night-700 dark:text-cream-200 truncate">{{ $music->title ?: ($music->embed_url ? __('YouTube Müzik') : __('Ses Dosyası')) }}</span>
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0 {{ $music->embed_url ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20' : 'bg-gold-50 text-gold-700 dark:bg-gold-500/10 dark:text-gold-400 border border-gold-200 dark:border-gold-500/20' }}">
                                                        {{ $music->embed_url ? __('Link') : __('Dosya') }}
                                                    </span>
                                                </div>
                                                <form action="{{ route('user.invitations.music.delete', $music) }}" method="POST" onsubmit="return confirm('{{ __("Silmek istediğine emin misin?") }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-600 transition-colors shrink-0 hover:bg-red-50 dark:hover:bg-red-500/10 px-2.5 py-1 rounded-lg">{{ __('Sil') }}</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700 mt-5">
                                        <span class="text-3xl block mb-2">🎵</span>
                                        <p class="text-night-400 dark:text-cream-400 text-sm font-medium">{{ __('Henüz müzik eklenmemiş') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🎬</span>
                                    <div>
                                        <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Videolar') }}</h2>
                                        <p class="text-xs text-night-400 dark:text-cream-400">{{ __('YouTube linki ekle veya MP4 dosyası yükle') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 sm:px-8 py-6 sm:py-8">
                                <form action="{{ route('user.invitations.videos.add', $invitation) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('YouTube / Vimeo URL') }}</label>
                                            <input type="url" name="url" placeholder="https://www.youtube.com/watch?v=..."
                                                class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 h-px bg-cream-200 dark:border-night-700"></div>
                                            <span class="text-xs font-semibold text-night-400 dark:text-cream-400">{{ __('VEYA') }}</span>
                                            <div class="flex-1 h-px bg-cream-200 dark:border-night-700"></div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('MP4 Video Yükle') }}</label>
                                            <div class="relative">
                                                <input type="file" name="video_file" accept="video/mp4,video/webm,video/quicktime"
                                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:text-white file:bg-gradient-to-r file:from-gold-500 file:to-rose-500 hover:file:from-gold-600 hover:file:to-rose-600 file:cursor-pointer cursor-pointer focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                            <p class="text-xs text-night-400 dark:text-cream-500 mt-1">{{ __('MP4, WebM veya MOV - maks. 100MB') }}</p>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <input type="text" name="caption" placeholder="{{ __('Video açıklaması') }}"
                                                class="w-full sm:flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            <button type="submit" class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all shadow-sm shrink-0 flex items-center justify-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                <span class="sm:hidden">{{ __('Ekle') }}</span>
                                                <span class="hidden sm:inline">{{ __('Ekle') }}</span>
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
                                                    <span class="text-sm font-semibold text-gold-700 dark:text-gold-400 truncate">{{ $video->caption ?: ($video->file_path ? 'MP4 Video' : 'Video') }}</span>
                                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0 {{ $video->file_path ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20' : 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border-rose-200 dark:border-rose-500/20' }}">{{ $video->file_path ? __('Yükleme') : ucfirst($video->type) }}</span>
                                                </div>
                                                <form action="{{ route('user.invitations.videos.delete', $video) }}" method="POST" onsubmit="return confirm('{{ __("Silmek istediğine emin misin?") }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-600 transition-colors shrink-0 hover:bg-red-50 dark:hover:bg-red-500/10 px-2.5 py-1 rounded-lg">{{ __('Sil') }}</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700 mt-5">
                                        <span class="text-3xl block mb-2">🎬</span>
                                        <p class="text-night-400 dark:text-cream-400 text-sm font-medium">{{ __('Henüz video eklenmemiş') }}</p>
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
                                <h4 class="font-bold text-night-900 dark:text-cream-100 text-sm">{{ __('Davetiye Linki') }}</h4>
                                <p class="text-xs text-night-400 dark:text-cream-400">{{ __('QR kod ve önizleme') }}</p>
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
                                    {{ __('📱 QR Kod') }}
                                </a>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-center py-2.5 rounded-xl text-sm font-semibold bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-300 hover:bg-cream-100 dark:hover:bg-night-700 border border-cream-200 dark:border-night-700 transition-all">
                                    {{ __('👁️ Önizle') }}
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6 bg-cream-50/50 dark:bg-night-900/50 rounded-xl border border-dashed border-cream-200 dark:border-night-700">
                                <span class="text-2xl block mb-2">🔗</span>
                                <p class="text-sm text-night-400 dark:text-cream-400">{{ __('Yayınlandığında link ve QR kod görünecek') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="border-t border-cream-100 dark:border-night-700">
                        <div class="p-5 sm:p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-500/20 dark:to-rose-500/10 flex items-center justify-center text-sm">📊</div>
                                <div>
                                    <h4 class="font-bold text-night-900 dark:text-cream-100 text-sm">{{ __('İstatistikler') }}</h4>
                                    <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Davetiye performansı') }}</p>
                                </div>
                            </div>
                            <div class="space-y-0 divide-y divide-cream-100 dark:divide-night-700">
                                <div class="flex items-center justify-between py-3 first:pt-0">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>👁️</span> {{ __('Görüntülenme') }}</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->views }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>📱</span> {{ __('QR Tarama') }}</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->qr_scans }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-sm text-night-400 dark:text-cream-400 flex items-center gap-2"><span>💌</span> RSVP</span>
                                    <span class="text-sm font-bold text-night-900 dark:text-cream-100 tabular-nums">{{ $invitation->rsvps_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                showBride: true, showBrideParents: true, showGroomMother: true, showBrideFather: true, showBrideMother: true, showStory: true, titleHint: 'D\u00fc\u011f\u00fcn Davetiyesi'
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
                showBride: false, showBrideParents: false, showGroomMother: true, showBrideFather: false, showBrideMother: false, showStory: false, titleHint: 'S\u00fcnnet Davetiyesi'
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
                showBride: true, showBrideParents: false, showGroomMother: true, showBrideFather: false, showBrideMother: false, showStory: false, titleHint: 'Do\u011fum G\u00fcn\u00fc Davetiyesi'
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
                showBride: true, showBrideParents: false, showGroomMother: false, showBrideFather: false, showBrideMother: false, showStory: false, titleHint: 'Kurumsal Davetiye'
            },
            graduation: {
                groomLabel: '\ud83c\udf93 Mezun Olan Ki\u015fi', groomPlaceholder: 'Ali',
                brideLabel: '', bridePlaceholder: '',
                groomParentTitle: 'Aile Bilgileri',
                brideParentTitle: '',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Ahmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: '', brideFatherPlaceholder: '',
                brideMotherLabel: '', brideMotherPlaceholder: '',
                showBride: false, showBrideParents: false, showGroomMother: true, showBrideFather: false, showBrideMother: false, showStory: false, titleHint: 'Mezuniyet Davetiyesi'
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
            show('editStoryField', l.showStory);
            show('editGroomMotherField', l.showGroomMother);
            show('editBrideFatherField', l.showBrideFather);
            show('editBrideMotherField', l.showBrideMother);

            var gf = document.querySelector('input[name="groom_father"]');
            if (gf) gf.placeholder = l.groomFatherPlaceholder;

            var bi = document.getElementById('editBrideInput');
            if (bi) bi.required = l.showBride;
        }

        function initEditEventFields() {
            var sel = document.getElementById('editEventTypeSelect');
            if (sel) {
                updateEditEventFields(sel.value);
                sel.addEventListener('change', function() { updateEditEventFields(this.value); });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initEditEventFields);
        } else {
            initEditEventFields();
        }
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

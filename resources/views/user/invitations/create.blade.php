<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">{{ __('Yeni Davetiye') }}</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">{{ __('Dijital davetiyeni oluşturmaya başla') }}</p>
            </div>
            <a href="{{ route('user.invitations.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-night-500 dark:text-cream-300 bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('Geri Dön') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 page-content">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('user.invitations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                @php
                    $etype = old('event_type', 'wedding');
                    $elabels = [
                        'wedding' => ['groomLabel'=>'👨 Damat Adı','groomPlaceholder'=>'Ahmet','brideLabel'=>'👰 Gelin Adı','bridePlaceholder'=>'Ayşe','groomParentTitle'=>'Damat Ailesi','brideParentTitle'=>'Gelin Ailesi','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Mehmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'Baba Adı','brideFatherPlaceholder'=>'Ahmet','brideMotherLabel'=>'Anne Adı','brideMotherPlaceholder'=>'Fatma','showBride'=>true,'showBrideParents'=>true,'showStory'=>true,'titleHint'=>'Düğün Davetiyesi'],
                        'engagement' => ['groomLabel'=>'👨 Damat Adı','groomPlaceholder'=>'Ahmet','brideLabel'=>'👰 Gelin Adı','bridePlaceholder'=>'Ayşe','groomParentTitle'=>'Erkek Ailesi','brideParentTitle'=>'Kız Ailesi','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Mehmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'Baba Adı','brideFatherPlaceholder'=>'Ahmet','brideMotherLabel'=>'Anne Adı','brideMotherPlaceholder'=>'Fatma','showBride'=>true,'showBrideParents'=>true,'showStory'=>true,'titleHint'=>'Nişan Davetiyesi'],
                        'circumcision' => ['groomLabel'=>'✂️ Çocuk Adı','groomPlaceholder'=>'Mehmet','brideLabel'=>'','bridePlaceholder'=>'','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>false,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Sünnet Davetiyesi'],
                        'birthday' => ['groomLabel'=>'🎂 Doğum Günü Kişisi','groomPlaceholder'=>'Ayşe','brideLabel'=>'Yaş','bridePlaceholder'=>'25','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>true,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Doğum Günü Davetiyesi'],
                        'corporate' => ['groomLabel'=>'🏢 Şirket / Organizasyon Adı','groomPlaceholder'=>'ACME Şirketi','brideLabel'=>'İletişim Kişisi','bridePlaceholder'=>'Ahmet Yılmaz','groomParentTitle'=>'Adres Bilgisi','brideParentTitle'=>'','groomFatherLabel'=>'Adres','groomFatherPlaceholder'=>'Mecidiyeköy, İstanbul','groomMotherLabel'=>'','groomMotherPlaceholder'=>'','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>true,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Kurumsal Davetiye'],
                        'graduation' => ['groomLabel'=>'🎓 Mezun Olan Kişi','groomPlaceholder'=>'Ali','brideLabel'=>'','bridePlaceholder'=>'','groomParentTitle'=>'Aile Bilgileri','brideParentTitle'=>'','groomFatherLabel'=>'Baba Adı','groomFatherPlaceholder'=>'Ahmet','groomMotherLabel'=>'Anne Adı','groomMotherPlaceholder'=>'Ayşe','brideFatherLabel'=>'','brideFatherPlaceholder'=>'','brideMotherLabel'=>'','brideMotherPlaceholder'=>'','showBride'=>false,'showBrideParents'=>false,'showStory'=>false,'titleHint'=>'Mezuniyet Davetiyesi'],
                    ];
                    $el = $elabels[$etype] ?? $elabels['wedding'];
                @endphp

                <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                    <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">💌</div>
                            <div>
                                <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Davetiye Bilgileri') }}</h2>
                                <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Temel bilgileri gir, sonra dilediğin gibi özelleştir.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 sm:px-8 py-6 sm:py-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('🎪 Etkinlik Türü') }}</label>
                                <div class="relative">
                                    <select name="event_type" id="eventTypeSelect"
                                        class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                        <option value="wedding" {{ old('event_type') === 'wedding' ? 'selected' : '' }}>{{ __('💍 Düğün') }}</option>
                                        <option value="engagement" {{ old('event_type') === 'engagement' ? 'selected' : '' }}>{{ __('💍 Nişan') }}</option>
                                        <option value="circumcision" {{ old('event_type') === 'circumcision' ? 'selected' : '' }}>{{ __('✂️ Sünnet') }}</option>
                                        <option value="birthday" {{ old('event_type') === 'birthday' ? 'selected' : '' }}>{{ __('🎂 Doğum Günü') }}</option>
                                        <option value="corporate" {{ old('event_type') === 'corporate' ? 'selected' : '' }}>{{ __('🏢 Kurumsal') }}</option>
                                        <option value="graduation" {{ old('event_type') === 'graduation' ? 'selected' : '' }}>{{ __('🎓 Mezuniyet') }}</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div id="coupleFields">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="groomLabel">{{ $el['groomLabel'] }}</label>
                                        <input type="text" name="groom_name" value="{{ old('groom_name') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="groomInput" placeholder="{{ $el['groomPlaceholder'] }}">
                                    </div>
                                    <div id="brideField" @if(!$el['showBride']) style="display:none" @endif>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="brideLabel">{{ $el['brideLabel'] }}</label>
                                        <input type="text" name="bride_name" value="{{ old('bride_name') }}" @if($el['showBride']) required @endif
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="brideInput" placeholder="{{ $el['bridePlaceholder'] }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mt-4 sm:mt-5" id="groomParents">
                                    <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700">
                                        <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <span>👪</span> <span id="groomParentTitle">{{ $el['groomParentTitle'] }}</span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="groomFatherLabel">{{ $el['groomFatherLabel'] }}</label>
                                                <input type="text" name="groom_father" value="{{ old('groom_father') }}" placeholder="{{ $el['groomFatherPlaceholder'] }}"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="groomMotherLabel">{{ $el['groomMotherLabel'] }}</label>
                                                <input type="text" name="groom_mother" value="{{ old('groom_mother') }}" placeholder="{{ $el['groomMotherPlaceholder'] }}"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700" id="brideParents" @if(!$el['showBrideParents']) style="display:none" @endif>
                                        <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <span>👪</span> <span id="brideParentTitle">{{ $el['brideParentTitle'] }}</span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="brideFatherLabel">{{ $el['brideFatherLabel'] }}</label>
                                                <input type="text" name="bride_father" value="{{ old('bride_father') }}" placeholder="{{ $el['brideFatherPlaceholder'] }}"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="brideMotherLabel">{{ $el['brideMotherLabel'] }}</label>
                                                <input type="text" name="bride_mother" value="{{ old('bride_mother') }}" placeholder="{{ $el['brideMotherPlaceholder'] }}"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Başlık') }}</label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" placeholder="{{ $el['titleHint'] }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('🔗 Kısa Link') }}</label>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm text-night-400 dark:text-cream-400 shrink-0">{{ url('/s/') }}</span>
                                    <input type="text" name="short_link" value="{{ old('short_link') }}"
                                        class="flex-1 w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all font-mono" placeholder="ozel-davetiyem-2025" pattern="[a-z0-9-]+">
                                </div>
                                <p class="text-xs text-night-400 dark:text-cream-400 mt-1.5">{{ __('Sadece küçük harf, rakam ve tire kullanın. Paylaşım linkiniz kısalır.') }}</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📅 Tarih') }}</label>
                                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('⏰ Saat') }}</label>
                                    <input type="time" name="event_time" value="{{ old('event_time') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📍 Adres') }}</label>
                                <textarea name="event_address" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none" placeholder="Mekan adı ve adresi">{{ old('event_address') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('💬 Karşılama Mesajı') }}</label>
                                <textarea name="welcome_message" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none" placeholder="Sevgili dostlarımız...">{{ old('welcome_message') }}</textarea>
                            </div>

                            <div id="storyField" @if(!$el['showStory']) style="display:none" @endif>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('💕 Hikayeniz') }}</label>
                                <textarea name="story" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none" placeholder="Birlikte geçirdiğiniz güzel günlerden bahsedin...">{{ old('story') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('📝 Özel Not') }}</label>
                                <textarea name="special_note" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all resize-none" placeholder="{{ __('Varsa eklemek istediğiniz özel not') }}">{{ old('special_note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-night-800 rounded-2xl shadow-sm border border-cream-200 dark:border-night-700 overflow-hidden">
                    <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-4 border-b border-cream-100 dark:border-night-700 bg-gradient-to-r from-cream-50 to-gold-50/30 dark:from-night-800 dark:to-gold-500/5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white dark:bg-night-800 shadow-sm flex items-center justify-center text-lg border border-cream-200 dark:border-night-700">🎨</div>
                            <div>
                                <h2 class="font-bold text-night-900 dark:text-cream-100">{{ __('Tema & Tasarım') }}</h2>
                                <p class="text-xs text-night-400 dark:text-cream-400">{{ __('Davetiyenin görünümünü seç.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 sm:px-8 py-6 sm:py-8">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Tema') }}</label>
                                <div class="relative">
                                    <select name="theme"
                                        class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                        @foreach($themes as $theme)
                                            <option value="{{ $theme->slug }}" {{ old('theme') === $theme->slug ? 'selected' : '' }}>{{ $theme->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Animasyonu') }}</label>
                                <div class="relative">
                                    <select name="envelope_animation"
                                        class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all appearance-none">
                                        <option value="classic" {{ old('envelope_animation') === 'classic' ? 'selected' : '' }}>{{ __('Klasik (Zarf Açılır)') }}</option>
                                        <option value="heart" {{ old('envelope_animation') === 'heart' ? 'selected' : '' }}>{{ __('Kalp Patlaması') }}</option>
                                        <option value="magic" {{ old('envelope_animation') === 'magic' ? 'selected' : '' }}>{{ __('Sihirli Işıltı') }}</option>
                                        <option value="flip" {{ old('envelope_animation') === 'flip' ? 'selected' : '' }}>{{ __('3D Dönüş') }}</option>
                                        <option value="ripple" {{ old('envelope_animation') === 'ripple' ? 'selected' : '' }}>{{ __('Dalga Efekti') }}</option>
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
                                            <option value="Cinzel" {{ old('font_family') === 'Cinzel' ? 'selected' : '' }}>Cinzel</option>
                                            <option value="Cormorant Garamond" {{ old('font_family') === 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond</option>
                                            <option value="Playfair Display" {{ old('font_family') === 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                                            <option value="Bodoni Moda" {{ old('font_family') === 'Bodoni Moda' ? 'selected' : '' }}>Bodoni Moda</option>
                                            <option value="DM Serif Display" {{ old('font_family') === 'DM Serif Display' ? 'selected' : '' }}>DM Serif Display</option>
                                        </optgroup>
                                        <optgroup label="{{ __('Modern ve Temiz') }}">
                                            <option value="Montserrat" {{ old('font_family') === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                            <option value="Poppins" {{ old('font_family') === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                                            <option value="Inter" {{ old('font_family') === 'Inter' ? 'selected' : '' }}>Inter</option>
                                            <option value="Manrope" {{ old('font_family') === 'Manrope' ? 'selected' : '' }}>Manrope</option>
                                            <option value="Outfit" {{ old('font_family') === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                                            <option value="Plus Jakarta Sans" {{ old('font_family') === 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans</option>
                                        </optgroup>
                                        <optgroup label="{{ __('Teknoloji ve Yazılım') }}">
                                            <option value="Space Grotesk" {{ old('font_family') === 'Space Grotesk' ? 'selected' : '' }}>Space Grotesk</option>
                                            <option value="Sora" {{ old('font_family') === 'Sora' ? 'selected' : '' }}>Sora</option>
                                            <option value="Exo 2" {{ old('font_family') === 'Exo 2' ? 'selected' : '' }}>Exo 2</option>
                                            <option value="Orbitron" {{ old('font_family') === 'Orbitron' ? 'selected' : '' }}>Orbitron</option>
                                            <option value="Rajdhani" {{ old('font_family') === 'Rajdhani' ? 'selected' : '' }}>Rajdhani</option>
                                        </optgroup>
                                        <optgroup label="{{ __('Kalın ve Dikkat Çekici') }}">
                                            <option value="Bebas Neue" {{ old('font_family') === 'Bebas Neue' ? 'selected' : '' }}>Bebas Neue</option>
                                            <option value="Anton" {{ old('font_family') === 'Anton' ? 'selected' : '' }}>Anton</option>
                                            <option value="League Spartan" {{ old('font_family') === 'League Spartan' ? 'selected' : '' }}>League Spartan</option>
                                            <option value="Oswald" {{ old('font_family') === 'Oswald' ? 'selected' : '' }}>Oswald</option>
                                            <option value="Teko" {{ old('font_family') === 'Teko' ? 'selected' : '' }}>Teko</option>
                                        </optgroup>
                                        <optgroup label="{{ __('İmza ve Şık Yazılar') }}">
                                            <option value="Great Vibes" {{ old('font_family') === 'Great Vibes' ? 'selected' : '' }}>Great Vibes</option>
                                            <option value="Allura" {{ old('font_family') === 'Allura' ? 'selected' : '' }}>Allura</option>
                                            <option value="Parisienne" {{ old('font_family') === 'Parisienne' ? 'selected' : '' }}>Parisienne</option>
                                            <option value="Alex Brush" {{ old('font_family') === 'Alex Brush' ? 'selected' : '' }}>Alex Brush</option>
                                            <option value="Brittany Signature" {{ old('font_family') === 'Brittany Signature' ? 'selected' : '' }}>Brittany Signature</option>
                                            <option value="Anydore" {{ old('font_family') === 'Anydore' ? 'selected' : '' }}>Anydore</option>
                                        </optgroup>
                                        <optgroup label="{{ __('Diğer') }}">
                                            <option value="Lora" {{ old('font_family') === 'Lora' ? 'selected' : '' }}>Lora</option>
                                            <option value="Blacksword" {{ old('font_family') === 'Blacksword' ? 'selected' : '' }}>Blacksword</option>
                                        </optgroup>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div x-data="{ selectedPattern: '{{ old('envelope_pattern', '') }}' }">
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-3">{{ __('Zarf Deseni') }}</label>

                                <div class="grid grid-cols-4 sm:grid-cols-4 gap-2.5 mb-4">
                                    <template x-for="p in window.envPatterns" :key="p.v">
                                        <button type="button"
                                            @click="selectedPattern = p.v"
                                            class="relative flex flex-col items-center gap-2 p-2 rounded-xl border-2 cursor-pointer transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-gold-400/40"
                                            :class="selectedPattern === p.v
                                                ? 'border-gold-500 bg-gold-50 dark:bg-gold-500/10 shadow-md'
                                                : 'border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 hover:shadow-sm'">
                                            <div class="w-full aspect-square rounded-lg overflow-hidden bg-gradient-to-br from-gold-400 to-gold-600 shadow-sm relative">
                                                <template x-if="p.img">
                                                    <img :src="p.img" class="absolute inset-0 w-full h-full object-cover">
                                                </template>
                                                <template x-if="!p.img">
                                                    <div :class="'pat-prev-' + p.v" class="absolute inset-0"></div>
                                                </template>
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
                            </div>

                            @php
                                $presets = [
                                    'primary' => ['#d4a61e','#c9952e','#e8c44a','#b8860b','#8b1a4a','#1a2a4a','#2d6a4f','#c1694f','#7ba0b0','#e8b4b8','#6b5ce7','#e75480'],
                                    'secondary' => ['#fefcf8','#fffdf5','#fdf2e9','#fdf2f2','#f0f4f8','#f5f0ff','#f0f4f0','#fef9e7','#fff5f5','#f3eeea','#f0fdf4','#ecfdf5'],
                                    'text' => ['#333333','#1a1a1a','#000000','#4a3728','#5c4033','#666666','#555555','#444444','#3d3d3d','#2d2d2d'],
                                    'flap' => ['#ffffff','#fefcf8','#fdf2f2','#fdf2e9','#f0f4f8','#f5f0ff','#fce7f3','#fff7ed','#f0fdf4','#fef2f2','#fffbeb','#faf5ff'],
                                    'bg' => ['#ffffff','#fefcf8','#fdf2f2','#fdf2e9','#f0f4f8','#f5f0ff','#fce7f3','#fff7ed','#f0fdf4','#fef2f2','#fffbeb','#faf5ff'],
                                ];
                            @endphp
                            <script>
                                function hexToHsl(hex) {
                                    let r = parseInt(hex.slice(1,3),16)/255, g = parseInt(hex.slice(3,5),16)/255, b = parseInt(hex.slice(5,7),16)/255;
                                    let mx = Math.max(r,g,b), mn = Math.min(r,g,b), h = 0, s = 0, l = (mx+mn)/2;
                                    if (mx !== mn) {
                                        let d = mx - mn;
                                        s = l > 0.5 ? d / (2 - mx - mn) : d / (mx + mn);
                                        if (mx === r) h = ((g - b) / d + (g < b ? 6 : 0)) / 6;
                                        else if (mx === g) h = ((b - r) / d + 2) / 6;
                                        else h = ((r - g) / d + 4) / 6;
                                    }
                                    return [h * 360, s * 100, l * 100];
                                }
                                function hslToHex(h, s, l) {
                                    s /= 100; l /= 100;
                                    let a = s * Math.min(l, 1 - l);
                                    let f = n => { let k = (n + h / 30) % 12; return Math.round(255 * (l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1))); };
                                    return '#' + [f(0), f(8), f(4)].map(x => x.toString(16).padStart(2,'0')).join('');
                                }
                                function generateSimilarColors(hex) {
                                    let [h, s, l] = hexToHsl(hex);
                                    let colors = [];
                                    for (let i = -5; i <= 6; i++) {
                                        let nh = (h + i * 8 + 360) % 360;
                                        let ns = Math.max(10, Math.min(100, s + (i % 3) * 8 - 8));
                                        let nl = Math.max(10, Math.min(95, l + (i % 4) * 6 - 9));
                                        colors.push(hslToHex(nh, ns, nl));
                                    }
                                    return colors;
                                }
                            </script>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Ana Renk') }}</label>
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="color" name="primary_color" value="{{ old('primary_color', '#d4a61e') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="document.getElementById('primary_color_text').value = this.value; updatePaletteNow('primary')">
                                        <input type="text" id="primary_color_text" value="{{ old('primary_color', '#d4a61e') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                    <div class="flex flex-wrap gap-1.5" id="palette_primary">
                                        @foreach($presets['primary'] as $hex)
                                        <button type="button" onclick="document.querySelector('[name=primary_color]').value='{{$hex}}'; document.getElementById('primary_color_text').value='{{$hex}}'; document.querySelector('[name=primary_color]').dispatchEvent(new Event('input'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:{{$hex}}"></button>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Arka Plan') }}</label>
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="color" name="secondary_color" value="{{ old('secondary_color', '#fefcf8') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="document.getElementById('secondary_color_text').value = this.value; updatePaletteNow('secondary')">
                                        <input type="text" id="secondary_color_text" value="{{ old('secondary_color', '#fefcf8') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                    <div class="flex flex-wrap gap-1.5" id="palette_secondary">
                                        @foreach($presets['secondary'] as $hex)
                                        <button type="button" onclick="document.querySelector('[name=secondary_color]').value='{{$hex}}'; document.getElementById('secondary_color_text').value='{{$hex}}'; document.querySelector('[name=secondary_color]').dispatchEvent(new Event('input'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:{{$hex}}"></button>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Yazı Rengi') }}</label>
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="color" name="envelope_text_color" value="{{ old('envelope_text_color', '#333333') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="document.getElementById('envelope_text_color_text').value = this.value; updatePaletteNow('envelope_text')">
                                        <input type="text" id="envelope_text_color_text" value="{{ old('envelope_text_color', '#333333') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                    <div class="flex flex-wrap gap-1.5" id="palette_envelope_text">
                                        @foreach($presets['text'] as $hex)
                                        <button type="button" onclick="document.querySelector('[name=envelope_text_color]').value='{{$hex}}'; document.getElementById('envelope_text_color_text').value='{{$hex}}'; document.querySelector('[name=envelope_text_color]').dispatchEvent(new Event('input'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:{{$hex}}"></button>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Üçgen Rengi') }}</label>
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="color" name="envelope_flap_color" value="{{ old('envelope_flap_color', '#ffffff') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="document.getElementById('envelope_flap_color_text').value = this.value; updatePaletteNow('envelope_flap')">
                                        <input type="text" id="envelope_flap_color_text" value="{{ old('envelope_flap_color', '#ffffff') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                    <div class="flex flex-wrap gap-1.5" id="palette_envelope_flap">
                                        @foreach($presets['flap'] as $hex)
                                        <button type="button" onclick="document.querySelector('[name=envelope_flap_color]').value='{{$hex}}'; document.getElementById('envelope_flap_color_text').value='{{$hex}}'; document.querySelector('[name=envelope_flap_color]').dispatchEvent(new Event('input'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:{{$hex}}"></button>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Arka Plan') }}</label>
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="color" name="envelope_bg_color" value="{{ old('envelope_bg_color', '#ffffff') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="document.getElementById('envelope_bg_color_text').value = this.value; updatePaletteNow('envelope_bg')">
                                        <input type="text" id="envelope_bg_color_text" value="{{ old('envelope_bg_color', '#ffffff') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                    <div class="flex flex-wrap gap-1.5" id="palette_envelope_bg">
                                        @foreach($presets['bg'] as $hex)
                                        <button type="button" onclick="document.querySelector('[name=envelope_bg_color]').value='{{$hex}}'; document.getElementById('envelope_bg_color_text').value='{{$hex}}'; document.querySelector('[name=envelope_bg_color]').dispatchEvent(new Event('input'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:{{$hex}}"></button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <script>
                                function updatePaletteNow(name) {
                                    let input = document.querySelector('[name="' + name + '_color"]');
                                    let text = document.getElementById(name + '_color_text');
                                    let container = document.getElementById('palette_' + name);
                                    if (!input || !container) return;
                                    let hex = input.value;
                                    if (text) text.value = hex;
                                    let colors = generateSimilarColors(hex);
                                    container.innerHTML = colors.map(c =>
                                        '<button type="button" onclick="document.querySelector(\'[name=' + name + '_color]\').value=\'' + c + '\'; document.getElementById(\'' + name + '_color_text\').value=\'' + c + '\'; document.querySelector(\'[name=' + name + '_color]\').dispatchEvent(new Event(\'input\'))" class="w-7 h-7 rounded-lg border border-cream-200 dark:border-night-700 cursor-pointer hover:scale-110 transition-transform shadow-sm" style="background:' + c + '"></button>'
                                    ).join('');
                                }
                                document.addEventListener('DOMContentLoaded', function() {
                                    ['primary', 'secondary', 'envelope_text', 'envelope_flap', 'envelope_bg'].forEach(function(n) {
                                        let input = document.querySelector('[name="' + n + '_color"]');
                                        if (input) input.addEventListener('input', function() { updatePaletteNow(n); });
                                    });
                                });
                            </script>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Kapak Fotoğrafı') }}</label>
                                <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-cream-200 dark:border-night-700 rounded-xl cursor-pointer bg-cream-50/50 dark:bg-night-900/50 hover:border-gold-400 hover:bg-gold-50/50 dark:hover:bg-gold-500/5 transition-all group">
                                    <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📸</span>
                                    <span class="text-sm text-night-400 dark:text-cream-400 font-medium">{{ __('Kapak fotoğrafı yüklemek için tıkla') }}</span>
                                    <span class="text-xs text-night-300 dark:text-night-500 mt-1">{{ __('Önerilen: 1200x800px') }}</span>
                                    <input type="file" name="cover_image" accept="image/*" class="hidden" onchange="this.parentElement.querySelectorAll('span')[1].textContent = this.files[0].name">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('user.invitations.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-night-500 dark:text-cream-300 bg-white dark:bg-night-800 border border-cream-200 dark:border-night-700 hover:border-gold-300 hover:text-gold-700 dark:hover:border-gold-500/30 dark:hover:text-gold-400 transition-all shadow-sm">
                        {{ __('İptal') }}
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl text-base font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 hover:-translate-y-0.5 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('Davetiye Oluştur') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



    <script>
        var eventTypeLabels = {
            wedding: {
                groomLabel: '👨 Damat Ad\u0131', groomPlaceholder: 'Ahmet',
                brideLabel: '\ud83d\udc70 Gelin Ad\u0131', bridePlaceholder: 'Ay\u015fe',
                groomParentTitle: 'Damat Ailesi',
                brideParentTitle: 'Gelin Ailesi',
                groomFatherLabel: 'Baba Ad\u0131', groomFatherPlaceholder: 'Mehmet',
                groomMotherLabel: 'Anne Ad\u0131', groomMotherPlaceholder: 'Ay\u015fe',
                brideFatherLabel: 'Baba Ad\u0131', brideFatherPlaceholder: 'Ahmet',
                brideMotherLabel: 'Anne Ad\u0131', brideMotherPlaceholder: 'Fatma',
                showBride: true, showBrideParents: true, showStory: true, titleHint: 'D\u00fc\u011f\u00fcn Davetiyesi'
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
                showBride: true, showBrideParents: true, showStory: true, titleHint: 'Ni\u015fan Davetiyesi'
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
                showBride: false, showBrideParents: false, showStory: false, titleHint: 'S\u00fcnnet Davetiyesi'
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
                showBride: true, showBrideParents: false, showStory: false, titleHint: 'Do\u011fum G\u00fcn\u00fc Davetiyesi'
            },
            corporate: {
                groomLabel: '\ud83c\udfe2 \u015eirket / Organizasyon Ad\u0131', groomPlaceholder: 'ACME \u015eirketi',
                brideLabel: '\u0130leti\u015fim Ki\u015fisi', bridePlaceholder: 'Ahmet Y\u0131lmaz',
                groomParentTitle: 'Adres Bilgisi',
                brideParentTitle: '',
                groomFatherLabel: 'Adres', groomFatherPlaceholder: 'Mecidiyek\u00f6y, \u0130stanbul',
                groomMotherLabel: '', groomMotherPlaceholder: '',
                brideFatherLabel: '', brideFatherPlaceholder: '',
                brideMotherLabel: '', brideMotherPlaceholder: '',
                showBride: true, showBrideParents: false, showStory: false, titleHint: 'Kurumsal Davetiye'
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
                showBride: false, showBrideParents: false, showStory: false, titleHint: 'Mezuniyet Davetiyesi'
            }
        };

        function updateEventTypeFields(type) {
            var labels = eventTypeLabels[type] || eventTypeLabels.wedding;
            var groomLabel = document.getElementById('groomLabel');
            var groomInput = document.getElementById('groomInput');
            var brideField = document.getElementById('brideField');
            var brideInput = document.getElementById('brideInput');
            var brideLabel = document.getElementById('brideLabel');
            var groomParents = document.getElementById('groomParents');
            var brideParents = document.getElementById('brideParents');
            var groomParentTitle = document.getElementById('groomParentTitle');
            var brideParentTitle = document.getElementById('brideParentTitle');
            var groomFatherLabel = document.getElementById('groomFatherLabel');
            var groomMotherLabel = document.getElementById('groomMotherLabel');
            var brideFatherLabel = document.getElementById('brideFatherLabel');
            var brideMotherLabel = document.getElementById('brideMotherLabel');
            var titleInput = document.querySelector('input[name="title"]');

            if (groomLabel) groomLabel.innerHTML = labels.groomLabel;
            if (groomInput) groomInput.placeholder = labels.groomPlaceholder;
            if (brideLabel) brideLabel.innerHTML = labels.brideLabel;

            if (brideField) brideField.style.display = labels.showBride ? '' : 'none';
            if (brideParents) brideParents.style.display = labels.showBrideParents ? '' : 'none';
            var storyField = document.getElementById('storyField');
            if (storyField) storyField.style.display = labels.showStory ? '' : 'none';

            if (brideInput) {
                brideInput.required = labels.showBride;
                brideInput.placeholder = labels.bridePlaceholder;
            }

            if (groomParentTitle) groomParentTitle.textContent = labels.groomParentTitle;
            if (brideParentTitle) brideParentTitle.textContent = labels.brideParentTitle;
            if (groomFatherLabel) groomFatherLabel.textContent = labels.groomFatherLabel;
            if (groomMotherLabel) {
                groomMotherLabel.textContent = labels.groomMotherLabel || ' ';
                groomMotherLabel.parentElement.style.display = labels.groomMotherLabel ? '' : 'none';
            }
            if (brideFatherLabel) {
                brideFatherLabel.textContent = labels.brideFatherLabel || ' ';
                brideFatherLabel.parentElement.style.display = labels.brideFatherLabel ? '' : 'none';
            }
            if (brideMotherLabel) {
                brideMotherLabel.textContent = labels.brideMotherLabel || ' ';
                brideMotherLabel.parentElement.style.display = labels.brideMotherLabel ? '' : 'none';
            }

            var fathers = document.querySelectorAll('input[name="groom_father"]');
            if (fathers[0]) fathers[0].placeholder = labels.groomFatherPlaceholder;

            if (titleInput && !titleInput.dataset.userEdited) {
                titleInput.placeholder = labels.titleHint;
            }
        }

        function initEventFields() {
            var select = document.getElementById('eventTypeSelect');
            if (select) {
                updateEventTypeFields(select.value);
                select.addEventListener('change', function() {
                    updateEventTypeFields(this.value);
                });
            }
            var titleInput = document.querySelector('input[name="title"]');
            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    this.dataset.userEdited = '1';
                });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initEventFields);
        } else {
            initEventFields();
        }
    </script>
    <script>
        window.envPatterns = [
            {v:'', l:'Yok'},
            @foreach($patterns as $pattern)
            {v:'a_{{ $pattern->slug }}', l:'{{ $pattern->name }}', img:'{{ \Illuminate\Support\Facades\Storage::url($pattern->image_path) }}'},
            @endforeach
        ];

        window.themes = @json($themes);

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
                    document.getElementById('primary_color_text').value = theme.primary_color;
                }
                if (secondaryInput && theme.secondary_color) {
                    secondaryInput.value = theme.secondary_color;
                    document.getElementById('secondary_color_text').value = theme.secondary_color;
                }
                if (fontSelect && theme.font_family) {
                    fontSelect.value = theme.font_family;
                }
            });
        });
    </script>
</x-app-layout>

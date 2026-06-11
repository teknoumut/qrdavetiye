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
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-night-400 dark:text-cream-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div id="coupleFields">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="groomLabel">{{ __('👨 Damat Adı') }}</label>
                                        <input type="text" name="groom_name" value="{{ old('groom_name') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="groomInput" placeholder="Ahmet">
                                    </div>
                                    <div id="brideField">
                                        <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5" id="brideLabel">{{ __('👰 Gelin Adı') }}</label>
                                        <input type="text" name="bride_name" value="{{ old('bride_name') }}" required
                                            class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" id="brideInput" placeholder="Ayşe">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mt-4 sm:mt-5" id="groomParents">
                                    <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700">
                                        <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <span>👪</span> <span id="groomParentTitle">{{ __('Damat Ailesi') }}</span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="groomFatherLabel">{{ __('Baba Adı') }}</label>
                                                <input type="text" name="groom_father" value="{{ old('groom_father') }}" placeholder="Mehmet"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="groomMotherLabel">{{ __('Anne Adı') }}</label>
                                                <input type="text" name="groom_mother" value="{{ old('groom_mother') }}" placeholder="Ayşe"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-cream-50 dark:bg-night-900/50 rounded-2xl p-4 sm:p-5 border border-cream-100 dark:border-night-700" id="brideParents">
                                        <p class="text-xs font-bold text-night-400 dark:text-cream-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <span>👪</span> <span id="brideParentTitle">{{ __('Gelin Ailesi') }}</span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="brideFatherLabel">{{ __('Baba Adı') }}</label>
                                                <input type="text" name="bride_father" value="{{ old('bride_father') }}" placeholder="Ahmet"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-night-500 dark:text-cream-300 mb-1" id="brideMotherLabel">{{ __('Anne Adı') }}</label>
                                                <input type="text" name="bride_mother" value="{{ old('bride_mother') }}" placeholder="Fatma"
                                                    class="w-full px-4 py-2.5 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Başlık') }}</label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-white dark:bg-night-900 text-night-900 dark:text-cream-100 text-sm placeholder:text-night-300 dark:placeholder:text-night-500 focus:border-gold-400 focus:ring-2 focus:ring-gold-100 dark:focus:ring-gold-500/20 outline-none transition-all" placeholder="{{ __('Düğün Davetiyesi') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('🔗 Kısa Link') }}</label>
                                <div class="flex items-center gap-2">
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

                            <div id="storyField">
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

                            <div class="grid grid-cols-2 gap-4 sm:gap-5">
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

                            <div>
                                <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-3">{{ __('Kendi Desenini Yükle') }}</label>

                                <div class="rounded-xl border-2 border-dashed border-cream-200 dark:border-night-700 hover:border-gold-300 dark:hover:border-gold-500/30 transition-all duration-200 overflow-hidden">
                                    <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                        <div class="w-10 h-10 rounded-lg bg-cream-100 dark:bg-night-700 flex items-center justify-center text-lg shrink-0 border border-cream-200 dark:border-night-600">
                                            <span>🖼️</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm font-semibold text-night-700 dark:text-cream-200 block leading-tight">{{ __('PNG, JPG, SVG — 64MB\'a kadar') }}</span>
                                            <span class="text-xs text-night-400 dark:text-cream-400 block mt-0.5" id="customFileLabel">{{ __('Dosya seçilmedi') }}</span>
                                        </div>
                                        <div class="px-3 py-1.5 rounded-lg text-xs font-semibold text-gold-700 dark:text-gold-400 bg-gold-50 dark:bg-gold-500/10 border border-gold-200 dark:border-gold-500/20 hover:bg-gold-100 dark:hover:bg-gold-500/20 transition-colors shrink-0">
                                            {{ __('Gözat') }}
                                        </div>
                                        <input type="file" name="custom_pattern" accept="image/png,image/jpeg,image/svg+xml" class="hidden"
                                            onchange="
                                                var label = document.getElementById('customFileLabel');
                                                if (this.files[0]) {
                                                    label.textContent = this.files[0].name;
                                                }
                                            ">
                                    </label>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Ana Renk') }}</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="primary_color" value="{{ old('primary_color', '#d4a61e') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="text" value="{{ old('primary_color', '#d4a61e') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Arka Plan') }}</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="secondary_color" value="{{ old('secondary_color', '#fefcf8') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="text" value="{{ old('secondary_color', '#fefcf8') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-night-700 dark:text-cream-200 mb-1.5">{{ __('Zarf Yazı Rengi') }}</label>
                                    <div class="flex gap-2 items-center">
                                        <input type="color" name="envelope_text_color" value="{{ old('envelope_text_color', '#333333') }}"
                                            class="w-14 h-12 rounded-xl border border-cream-200 dark:border-night-700 cursor-pointer bg-white p-0.5"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="text" value="{{ old('envelope_text_color', '#333333') }}" readonly
                                            class="flex-1 px-4 py-3 rounded-xl border border-cream-200 dark:border-night-700 bg-cream-50 dark:bg-night-900 text-night-500 dark:text-cream-400 text-sm font-mono">
                                    </div>
                                </div>
                            </div>

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

        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
    <script>
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

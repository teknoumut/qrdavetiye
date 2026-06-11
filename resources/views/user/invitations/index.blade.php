<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-night-900 dark:text-cream-100 tracking-tight">{{ __('Davetiyelerim') }}</h1>
                <p class="text-sm text-night-400 dark:text-cream-400 mt-1">{{ __('Tüm davetiyelerini yönet') }}</p>
            </div>
            <a href="{{ route('user.invitations.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                {{ __('Yeni Davetiye') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 page-content">
        @if($invitations->count() === 0)
            <div class="text-center py-20 animate-fade-in">
                <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-gold-100 to-rose-100 dark:from-gold-500/20 dark:to-rose-500/10 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-gold-200/30 dark:shadow-gold-500/10">
                    <span class="text-5xl">💌</span>
                </div>
                <h2 class="text-2xl font-bold text-night-900 dark:text-cream-100 mb-2">{{ __('Henüz Davetiye Yok') }}</h2>
                <p class="text-night-400 dark:text-cream-400 mb-10 max-w-sm mx-auto">{{ __('İlk dijital davetiyeni oluştur ve sevdiklerinle paylaş!') }}</p>
                <a href="{{ route('user.invitations.create') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-xl text-base font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 shadow-lg shadow-gold-200/50 dark:shadow-gold-500/20 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    {{ __('İlk Davetiyeni Oluştur') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($invitations as $inv)
                    @php
                        $cardBorderStyles = ['wedding'=>'border-l-rose-300 dark:border-l-rose-500/40','engagement'=>'border-l-purple-300 dark:border-l-purple-500/40','circumcision'=>'border-l-cyan-300 dark:border-l-cyan-500/40','birthday'=>'border-l-pink-300 dark:border-l-pink-500/40','corporate'=>'border-l-blue-300 dark:border-l-blue-500/40','graduation'=>'border-l-purple-300 dark:border-l-purple-500/40'];
                        $cardBorder = $cardBorderStyles[$inv->event_type] ?? $cardBorderStyles['wedding'];
                    @endphp
                    <div class="group bg-white dark:bg-night-800 rounded-2xl border border-cream-200 dark:border-night-700 border-l-4 {{ $cardBorder }} shadow-sm hover:shadow-lg hover:border-gold-200 dark:hover:border-gold-500/30 transition-all duration-300 overflow-hidden animate-scale-in hover:-translate-y-1">
                        @if($inv->cover_image)
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($inv->cover_image) }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105" alt="">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                <div class="absolute top-3 right-3 flex gap-1.5">
                                    <span class="text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm {{ $inv->is_published ? 'bg-emerald-500/80 text-white' : 'bg-night-800/60 text-white' }}">
                                        {{ $inv->is_published ? __('Yayında') : __('Taslak') }}
                                    </span>
                                </div>
                            </div>
                        @else
                            @php
                                $eType = $inv->event_type ?: 'wedding';
                                $eventCardStyles = [
                                    'wedding' => ['bg' => 'from-gold-100 via-rose-50 to-amber-50', 'dark' => 'dark:from-gold-500/10 dark:via-rose-500/5 dark:to-amber-500/10', 'icon' => '💍', 'text' => 'from-gold-400 to-rose-400'],
                                    'engagement' => ['bg' => 'from-gold-100 via-purple-50 to-pink-50', 'dark' => 'dark:from-gold-500/10 dark:via-purple-500/5 dark:to-pink-500/10', 'icon' => '💍', 'text' => 'from-gold-400 to-purple-400'],
                                    'circumcision' => ['bg' => 'from-sky-100 via-cyan-50 to-teal-50', 'dark' => 'dark:from-sky-500/10 dark:via-cyan-500/5 dark:to-teal-500/10', 'icon' => '✂️', 'text' => 'from-sky-400 to-cyan-400'],
                                    'birthday' => ['bg' => 'from-pink-100 via-rose-50 to-orange-50', 'dark' => 'dark:from-pink-500/10 dark:via-rose-500/5 dark:to-orange-500/10', 'icon' => '🎂', 'text' => 'from-pink-400 to-orange-400'],
                                    'corporate' => ['bg' => 'from-slate-100 via-blue-50 to-indigo-50', 'dark' => 'dark:from-slate-500/10 dark:via-blue-500/5 dark:to-indigo-500/10', 'icon' => '🏢', 'text' => 'from-slate-400 to-blue-400'],
                                    'graduation' => ['bg' => 'from-purple-100 via-indigo-50 to-gold-50', 'dark' => 'dark:from-purple-500/10 dark:via-indigo-500/5 dark:to-gold-500/10', 'icon' => '🎓', 'text' => 'from-purple-400 to-gold-400'],
                                ];
                                $cardStyle = $eventCardStyles[$eType] ?? $eventCardStyles['wedding'];
                            @endphp
                            <div class="h-48 bg-gradient-to-br {{ $cardStyle['bg'] }} {{ $cardStyle['dark'] }} flex items-center justify-center relative">
                                <span class="text-6xl">{{ $cardStyle['icon'] }}</span>
                                <div class="absolute top-3 right-3 flex gap-1.5">
                                    <span class="text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm {{ $inv->is_published ? 'bg-emerald-500/80 text-white' : 'bg-night-800/60 text-white' }}">
                                        {{ $inv->is_published ? __('Yayında') : __('Taslak') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="mb-3">
                                @php
                                    $typeNames = ['wedding'=>'💍 '.__('Düğün'),'engagement'=>'💍 '.__('Nişan'),'circumcision'=>'✂️ '.__('Sünnet'),'birthday'=>'🎂 '.__('Doğum Günü'),'corporate'=>'🏢 '.__('Kurumsal'),'graduation'=>'🎓 '.__('Mezuniyet')];
                                    $typeName = $typeNames[$inv->event_type] ?? '💍 '.__('Düğün');
                                    $typeBadgeStyles = [
                                        'wedding' => 'bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-500/10 dark:text-rose-300 dark:border-rose-500/30',
                                        'engagement' => 'bg-purple-50 text-purple-600 border-purple-200 dark:bg-purple-500/10 dark:text-purple-300 dark:border-purple-500/30',
                                        'circumcision' => 'bg-cyan-50 text-cyan-600 border-cyan-200 dark:bg-cyan-500/10 dark:text-cyan-300 dark:border-cyan-500/30',
                                        'birthday' => 'bg-pink-50 text-pink-600 border-pink-200 dark:bg-pink-500/10 dark:text-pink-300 dark:border-pink-500/30',
                                        'corporate' => 'bg-blue-50 text-blue-600 border-blue-200 dark:bg-blue-500/10 dark:text-blue-300 dark:border-blue-500/30',
                                        'graduation' => 'bg-purple-50 text-purple-600 border-purple-200 dark:bg-purple-500/10 dark:text-purple-300 dark:border-purple-500/30',
                                    ];
                                    $badgeStyle = $typeBadgeStyles[$inv->event_type] ?? $typeBadgeStyles['wedding'];
                                @endphp
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <h3 class="font-bold text-night-900 dark:text-cream-100 text-lg leading-tight group-hover:text-gold-700 dark:group-hover:text-gold-400 transition-colors truncate">{{ $inv->title }}</h3>
                                    <span class="shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full {{ $badgeStyle }} whitespace-nowrap">{{ $typeName }}</span>
                                </div>
                                <p class="text-sm text-night-400 dark:text-cream-400 mt-0.5 font-medium">{{ $inv->groom_name }} @if(!$inv->event_type || $inv->event_type === 'wedding' || $inv->event_type === 'engagement')<span class="text-gold-400">&</span> {{ $inv->bride_name }}@endif</p>
                            </div>
                            @if($inv->event_date)
                                <div class="flex items-center gap-3 text-xs text-night-400 dark:text-cream-400 mb-4 bg-cream-50 dark:bg-night-900/50 rounded-xl px-3 py-2 border border-cream-100 dark:border-night-700">
                                    <span class="flex items-center gap-1.5"><span>📅</span> {{ $inv->event_date->format('d.m.Y') }}</span>
                                    @if($inv->event_time)<span class="flex items-center gap-1.5"><span>⏰</span> {{ $inv->event_time }}</span>@endif
                                </div>
                            @endif
                            <div class="flex items-center gap-4 text-xs text-night-400 dark:text-cream-400 mb-4 pb-4 border-b border-cream-100 dark:border-night-700">
                                <span class="flex items-center gap-1.5"><span>👁️</span> <strong class="text-night-700 dark:text-cream-300">{{ $inv->views }}</strong></span>
                                <a href="{{ route('user.invitations.rsvps', $inv) }}" class="flex items-center gap-1.5 hover:text-gold-600 dark:hover:text-gold-400 transition-colors"><span>💌</span> <strong class="text-night-700 dark:text-cream-300">{{ $inv->rsvps_count }}</strong></a>
                                @if($inv->qr_scans)<span class="flex items-center gap-1.5"><span>📱</span> <strong class="text-night-700 dark:text-cream-300">{{ $inv->qr_scans }}</strong></span>@endif
                            </div>
                            <div class="flex gap-2.5">
                                <a href="{{ route('user.invitations.edit', $inv) }}" class="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-gold-500 to-rose-500 hover:from-gold-600 hover:to-rose-600 transition-all duration-200 shadow-sm shadow-gold-200/30 dark:shadow-gold-500/10">
                                    {{ __('Düzenle') }}
                                </a>
                                <a href="{{ route('user.invitations.show', $inv) }}" class="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-night-500 dark:text-cream-300 bg-cream-50 dark:bg-night-900 border border-cream-200 dark:border-night-700 hover:border-gold-200 dark:hover:border-gold-500/30 hover:text-gold-700 dark:hover:text-gold-400 transition-all duration-200">
                                    {{ __('İstatistik') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $invitations->links() }}</div>
        @endif
    </div>
</x-app-layout>

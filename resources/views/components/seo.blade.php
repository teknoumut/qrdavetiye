@php
    $siteName = \App\Models\Setting::getValue('site_name', config('app.name', 'senin 💝 davetiyen'));
    $siteDescription = \App\Models\Setting::getValue('site_description', 'Özel günleriniz için modern ve şık dijital davetiyeler');
    $siteLogo = \App\Models\Setting::getValue('site_logo', '');
    $title = $title ?? $siteName;
    $description = $description ?? $siteDescription;
    $image = $image ?? ($siteLogo ? asset('storage/'.$siteLogo) : '');
    $url = $url ?? url()->current();
    $type = $type ?? 'website';
    $siteFavicon = \App\Models\Setting::getValue('site_favicon', '');
@endphp
<title>{{ $title }}</title>
<meta name="google-site-verification" content="googleb55184e3cb1fc2cc" />
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">
@if($siteFavicon)
<link rel="icon" type="image/png" href="{{ asset('storage/'.$siteFavicon) }}?v={{ @filemtime(public_path('storage/'.$siteFavicon)) }}">
@else
<link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
<link rel="alternate icon" href="{{ asset('favicon.ico') }}">
@endif
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($image)
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
<meta name="twitter:image" content="{{ $image }}">
@endif
@hasSection('seo_extra')
    @yield('seo_extra')
@endif

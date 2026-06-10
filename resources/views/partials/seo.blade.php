@php
    $seoTitle = trim($__env->yieldContent('title', config('seo.default_title')));
    $seoDescription = trim($__env->yieldContent('meta_description', config('seo.default_description')));
    $seoCanonical = trim($__env->yieldContent('canonical', request()->url()));
    $seoRobots = trim($__env->yieldContent('robots', 'index, follow'));
    $seoType = trim($__env->yieldContent('og_type', 'website'));
    $seoImage = trim($__env->yieldContent('social_image', asset(config('seo.default_image'))));
    $seoTwitterHandle = config('seo.twitter_handle');

    $sameAs = array_values(array_filter([
        config('seo.person.linkedin'),
        config('seo.person.github'),
    ]));

    $personStructuredData = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        '@id' => route('home') . '#person',
        'name' => config('seo.person.name'),
        'url' => route('home'),
        'image' => asset(config('seo.default_image')),
        'jobTitle' => config('seo.person.job_title'),
        'email' => config('seo.person.email'),
        'sameAs' => $sameAs ?: null,
        'knowsAbout' => [
            'Desarrollo web',
            'Desarrollo de aplicaciones',
            'Laravel',
            'PHP',
            'JavaScript',
        ],
    ], fn ($value) => $value !== null && $value !== '');

    $websiteStructuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => route('home') . '#website',
        'url' => route('home'),
        'name' => config('seo.site_name'),
        'description' => config('seo.default_description'),
        'inLanguage' => 'es',
        'publisher' => ['@id' => route('home') . '#person'],
    ];

    $serviceStructuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        '@id' => route('home') . '#service',
        'name' => config('seo.site_name'),
        'url' => route('home'),
        'description' => config('seo.default_description'),
        'image' => asset(config('seo.default_image')),
        'provider' => ['@id' => route('home') . '#person'],
        'areaServed' => 'ES',
        'serviceType' => [
            'Desarrollo web',
            'Desarrollo de aplicaciones',
            'Soluciones digitales a medida',
        ],
    ];
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">

<meta property="og:locale" content="{{ config('seo.locale') }}">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:alt" content="{{ config('seo.person.name') }} - {{ config('seo.person.job_title') }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
@if ($seoTwitterHandle)
    <meta name="twitter:site" content="{{ $seoTwitterHandle }}">
    <meta name="twitter:creator" content="{{ $seoTwitterHandle }}">
@endif

<script type="application/ld+json">{!! json_encode($personStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($websiteStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($serviceStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@stack('structured-data')

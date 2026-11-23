<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="jmc-light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            (function () {
                try {
                    var stored = localStorage.getItem('jmc-theme');
                    var dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                    document.documentElement.setAttribute('data-theme', dark ? 'jmc-dark' : 'jmc-light');
                    document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
                } catch (error) {
                    document.documentElement.setAttribute('data-theme', 'jmc-light');
                }
            })();
        </script>

        @php
            $seo = $page['props']['seo'] ?? [];
            $site = $page['props']['site'] ?? [];
            $siteName = $site['name'] ?? config('site.name');
            $siteUrl = rtrim($site['url'] ?? config('site.url'), '/');
            $isErrorPage = str_starts_with($page['component'] ?? '', 'Errors/');
            $errorStatus = $page['props']['status'] ?? 404;
            $pageTitle = $seo['title'] ?? match (true) {
                $isErrorPage && $errorStatus === 403 => 'Accès refusé',
                $isErrorPage && $errorStatus === 404 => 'Page introuvable',
                $isErrorPage => 'Erreur',
                default => $siteName,
            };
            $fullTitle = $pageTitle === $siteName ? $pageTitle : $pageTitle.' — '.$siteName;
            $description = $seo['description'] ?? ($site['description'] ?? config('site.description'));
            $path = $seo['path'] ?? ('/'.ltrim(request()->path(), '/'));
            $canonical = $siteUrl.$path;
            $ogImagePath = $seo['og_image'] ?? ($site['og_image'] ?? config('site.og_image'));
            $ogImage = str_starts_with((string) $ogImagePath, 'http')
                ? $ogImagePath
                : $siteUrl.$ogImagePath;
            $organization = [
                '@type' => 'Organization',
                '@id' => $siteUrl.'/#organization',
                'name' => $site['legal_name'] ?? config('site.legal_name'),
                'url' => $siteUrl.'/',
                'logo' => $siteUrl.($site['logo'] ?? config('site.logo')),
            ];
            $slogan = $site['slogan'] ?? config('site.slogan');
            if (! empty($slogan)) {
                $organization['slogan'] = $slogan;
            }
            $contact = $site['contact'] ?? [];
            if (! empty($contact['email'])) {
                $organization['email'] = $contact['email'];
            }
            $address = $contact['address'] ?? [];
            if (! empty($address['city'])) {
                $organization['address'] = array_filter([
                    '@type' => 'PostalAddress',
                    'streetAddress' => $address['street'] ?? null,
                    'addressLocality' => $address['city'] ?? null,
                    'addressRegion' => $address['province'] ?? null,
                    'addressCountry' => 'CD',
                ]);
            }
            $phones = $contact['phones'] ?? [];
            if (! empty($phones)) {
                $organization['telephone'] = $phones[0]['e164'] ?? null;
                $organization['contactPoint'] = array_map(
                    fn (array $phone): array => array_filter([
                        '@type' => 'ContactPoint',
                        'contactType' => 'customer service',
                        'telephone' => $phone['e164'] ?? null,
                        'areaServed' => $phone['area'] ?? null,
                        'availableLanguage' => ['fr', 'en'],
                    ]),
                    $phones,
                );
            }
            if (! empty($site['social'])) {
                $organization['sameAs'] = array_column($site['social'], 'url');
            }
            $jsonLd = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $organization,
                    [
                        '@type' => 'WebSite',
                        '@id' => $siteUrl.'/#website',
                        'url' => $siteUrl.'/',
                        'name' => $siteName,
                        'inLanguage' => 'fr',
                        'publisher' => ['@id' => $siteUrl.'/#organization'],
                    ],
                    [
                        '@type' => $seo['type'] ?? 'WebPage',
                        '@id' => $canonical.'#webpage',
                        'url' => $canonical,
                        'name' => $fullTitle,
                        'description' => $description,
                        'isPartOf' => ['@id' => $siteUrl.'/#website'],
                        'about' => ['@id' => $siteUrl.'/#organization'],
                    ],
                ],
            ];
        @endphp

        <title data-inertia>{{ $fullTitle }}</title>
        <meta name="description" content="{{ $description }}">
        <link rel="canonical" href="{{ $canonical }}">
        @if ($isErrorPage)
            <meta name="robots" content="noindex, nofollow">
        @elseif (! empty($seo['robots']))
            <meta name="robots" content="{{ $seo['robots'] }}">
        @elseif (empty($seo) && (request()->is('login') || request()->is('register') || request()->is('forgot-password') || request()->is('reset-password*') || request()->is('confirm-password') || request()->is('verify-email*') || request()->is('dashboard') || request()->is('profile*')))
            <meta name="robots" content="noindex, nofollow">
        @endif

        <meta property="og:title" content="{{ $fullTitle }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:type" content="{{ ($seo['type'] ?? 'WebPage') === 'Article' ? 'article' : 'website' }}">
        <meta property="og:url" content="{{ $canonical }}">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:locale" content="{{ $site['locale'] ?? config('site.locale') }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:alt" content="{{ $fullTitle }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $fullTitle }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <script type="application/ld+json" data-seo-jsonld>{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        {{-- Favicons & site manifest --}}
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="theme-color" content="#101A79">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>

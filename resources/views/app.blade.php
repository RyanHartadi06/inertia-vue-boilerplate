<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>HCMS - PT SIER</title>
    <meta name="description"
        content="HCMS PT SIER">
    <meta name="keywords"
        content="HCMS, SIER">
    <meta name="author" content="Themesbrand">

    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="HCMS - PT SIER">
    <meta property="og:description"
        content="HCMS, SIER">
    <meta property="og:image" content="URL to the template's logo or featured image">
    <meta property="og:url" content="URL to the template's webpage">
    <meta name="twitter:card" content="summary_large_image">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.png') }}">

    <!-- Scripts -->
    @routes
    @vite([
        'resources/js/app.js',
        'resources/scss/config/corporate/bootstrap.scss',
        'resources/scss/config/corporate/app.scss',
    ])
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>

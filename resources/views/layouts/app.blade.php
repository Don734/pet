<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="/images/assets/icons/favicon.ico">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <script src="https://unpkg.com/htmx.org@1.9.3"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="2xl:flex 2xl:flex-wrap justify-center antialiased font-inter">

    <x-category-menu-component />

    @yield('content')
    @include('cookie-consent::index')

    <x-footer-component />

    </body>
</html>

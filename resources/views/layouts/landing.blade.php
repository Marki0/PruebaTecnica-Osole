<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nikitos Snacks')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ mix('css/site.css') }}">
    @stack('styles')
</head>
<body class="nikitos-landing @yield('body_class', '')">
    <a class="nk-skip" href="#contenido-principal">Ir al contenido</a>
    @include('partials.landing-header')
    <main id="contenido-principal">
        @yield('content')
    </main>
    @include('partials.landing-footer')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @include('partials.landing-scripts')
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Nikitos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/site.css') }}">
    @stack('styles')
</head>
<body class="nikitos-admin-body">
    <header class="nikitos-admin-header">
        <a href="{{ route('admin.dashboard') }}" class="nikitos-admin-logo" aria-label="Nikitos snacks — panel">
            <img src="{{ \App\Support\Landing::nk('image 177.png') }}" alt="Nikitos snacks" width="180" height="50" decoding="async">
        </a>

        <nav class="nikitos-admin-nav" aria-label="Panel">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Inicio</a>
            <a href="{{ route('admin.site-sections.index') }}" class="{{ request()->routeIs('admin.site-sections.*') ? 'is-active' : '' }}">Textos</a>
            <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'is-active' : '' }}">Banners</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">Categorías</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">Productos</a>
            <a href="{{ route('admin.recipes.index') }}" class="{{ request()->routeIs('admin.recipes.*') ? 'is-active' : '' }}">Recetas</a>
            <a href="{{ route('admin.contact-messages.index') }}" class="{{ request()->routeIs('admin.contact-messages.*') ? 'is-active' : '' }}">Contacto</a>
        </nav>

        <div class="nikitos-admin-user">
            <details>
                <summary>{{ Auth::user()->name }}</summary>
                <div class="nikitos-user__menu">
                    <a href="{{ route('home') }}" target="_blank" rel="noopener">Ver sitio público</a>
                    <form action="{{ route('logout') }}" method="post" style="margin:0;">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </details>
        </div>
    </header>

    <main class="nikitos-admin-main">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="nikitos-admin-footer">
        Nikitos snacks · Panel de administración · <a href="{{ route('home') }}">Ir al sitio</a>
    </footer>

    @stack('scripts')
</body>
</html>

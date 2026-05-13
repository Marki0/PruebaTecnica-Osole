<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Nikitos</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #fafafa; color: #18181b; }
        .admin-shell { display: flex; min-height: 100vh; }
        .admin-nav { width: 220px; background: #18181b; color: #fafafa; padding: 1rem; flex-shrink: 0; }
        .admin-nav a { color: #e4e4e7; text-decoration: none; display: block; padding: 0.35rem 0; font-size: 0.9rem; }
        .admin-nav a:hover { color: #fff; }
        .admin-nav strong { display: block; margin-bottom: 1rem; font-size: 1rem; }
        .admin-main { flex: 1; padding: 1.5rem 2rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-nav">
            <strong>Nikitos Admin</strong>
            <a href="{{ route('admin.dashboard') }}">Inicio</a>
            <a href="{{ route('admin.site-sections.index') }}">Textos y secciones</a>
            <a href="{{ route('admin.banners.index') }}">Banners</a>
            <a href="{{ route('admin.categories.index') }}">Categorías</a>
            <a href="{{ route('admin.products.index') }}">Productos</a>
            <a href="{{ route('admin.recipes.index') }}">Recetas</a>
            <a href="{{ route('admin.contact-messages.index') }}">Contacto</a>
            <hr style="border-color:#3f3f46;margin:1rem 0;">
            <form action="{{ route('logout') }}" method="post" style="margin:0;">
                @csrf
                <button type="submit" style="background:transparent;border:0;color:#a1a1aa;cursor:pointer;padding:0;font:inherit;font-size:0.9rem;">Cerrar sesión</button>
            </form>
        </aside>
        <div class="admin-main">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>

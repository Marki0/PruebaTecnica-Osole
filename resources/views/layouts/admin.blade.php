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
        .admin-main { flex: 1; padding: 1.5rem 2rem; max-width: 960px; }
        .admin-flash { padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.95rem; }
        .admin-flash--ok { background: #dcfce7; color: #14532d; border: 1px solid #86efac; }
        .admin-flash--err { background: #fee2e2; color: #7f1d1d; border: 1px solid #fecaca; }
        .admin-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,.06); }
        .admin-table th, .admin-table td { text-align: left; padding: 0.65rem 0.75rem; border-bottom: 1px solid #e4e4e7; font-size: 0.9rem; vertical-align: middle; }
        .admin-table th { background: #f4f4f5; font-weight: 600; }
        .admin-table tr:last-child td { border-bottom: 0; }
        .admin-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 6px; background: #e4e4e7; }
        .btn { display: inline-block; padding: 0.45rem 0.85rem; border-radius: 6px; font-size: 0.9rem; text-decoration: none; border: 1px solid transparent; cursor: pointer; }
        .btn-primary { background: #18181b; color: #fafafa; }
        .btn-secondary { background: #fff; color: #18181b; border-color: #d4d4d8; }
        .btn-danger { background: #b91c1c; color: #fff; }
        .btn-sm { padding: 0.3rem 0.55rem; font-size: 0.8rem; }
        .form-stack { display: grid; gap: 1rem; max-width: 32rem; }
        .form-stack label { font-weight: 600; font-size: 0.9rem; display: block; margin-bottom: 0.25rem; }
        .form-stack input[type="text"], .form-stack input[type="number"], .form-stack textarea { width: 100%; max-width: 32rem; padding: 0.5rem 0.6rem; border: 1px solid #d4d4d8; border-radius: 6px; font: inherit; box-sizing: border-box; }
        .form-stack textarea { min-height: 6rem; resize: vertical; }
        .form-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .muted { color: #71717a; font-size: 0.85rem; }
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
            @include('partials.flash')
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>

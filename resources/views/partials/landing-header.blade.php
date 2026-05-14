<header class="nk-header">
    <div class="nk-header__inner">
        <a class="nk-logo" href="{{ route('home') }}" aria-label="Nikitos Snacks inicio">
            <img class="nk-logo__img" src="{{ \App\Support\Landing::nk('image 177.png') }}" alt="Nikitos snacks" width="200" height="56" decoding="async">
        </a>
        <nav class="nk-nav" aria-label="Principal">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('productos') }}" class="{{ request()->routeIs('productos', 'productos.category') ? 'is-active' : '' }}">Productos</a>
            <a href="{{ route('donde-comprar') }}" class="{{ request()->routeIs('donde-comprar') ? 'is-active' : '' }}">Donde comprar</a>
            <a href="{{ route('recetas') }}" class="{{ request()->routeIs('recetas', 'recetas.show') ? 'is-active' : '' }}">Recetas</a>
            <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'is-active' : '' }}">Nosotros</a>
            <a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'is-active' : '' }}">Contacto</a>
        </nav>
        <div class="nk-header__actions">
            <a class="nk-btn nk-btn--ingresar" href="{{ route('login') }}">
                <svg class="nk-icon-lock" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/>
                </svg>
                Ingresar
            </a>
            <button type="button" class="nk-menu-toggle" id="nk-open-menu" aria-label="Abrir menú">☰</button>
        </div>
    </div>
</header>

<div class="nk-drawer" id="nk-drawer">
    <div class="nk-drawer__backdrop" id="nk-drawer-backdrop"></div>
    <div class="nk-drawer__panel">
        <button type="button" class="nk-drawer__close" id="nk-close-menu" aria-label="Cerrar">×</button>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('productos') }}">Productos</a>
        <a href="{{ route('donde-comprar') }}">Donde comprar</a>
        <a href="{{ route('recetas') }}">Recetas</a>
        <a href="{{ route('nosotros') }}">Nosotros</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('login') }}">Ingresar</a>
    </div>
</div>

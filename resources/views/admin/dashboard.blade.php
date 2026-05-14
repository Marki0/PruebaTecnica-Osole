@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
    <div class="nikitos-admin-dash">
        <header class="nikitos-admin-dash__intro">
            <h1 class="nikitos-admin-dash__title">Panel</h1>
            <p class="nikitos-admin-dash__lede muted">
                Gestioná textos, banners, categorías, productos, recetas y mensajes de contacto desde el menú superior o desde los accesos de abajo.
                La arquitectura del back-end está resumida en <code>docs/backend-arquitectura.md</code>.
            </p>
        </header>

        <nav class="nikitos-admin-dash-grid" aria-label="Accesos rápidos al contenido">
            <a href="{{ route('admin.site-sections.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Textos y secciones</span>
                    <span class="nikitos-admin-dash-card__desc">Contenido editable por bloques y claves del sitio.</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>

            <a href="{{ route('admin.banners.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3A1.5 1.5 0 0 0 1.5 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008H12V8.25Z"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Banners</span>
                    <span class="nikitos-admin-dash-card__desc">Imágenes por ubicación (home, secciones, etc.).</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Categorías</span>
                    <span class="nikitos-admin-dash-card__desc">Líneas de productos y orden en la tienda.</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Productos</span>
                    <span class="nikitos-admin-dash-card__desc">Fichas, imágenes y publicación en el catálogo.</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>

            <a href="{{ route('admin.recipes.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Recetas</span>
                    <span class="nikitos-admin-dash-card__desc">Ideas con productos Nikitos y estado de publicación.</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>

            <a href="{{ route('admin.contact-messages.index') }}" class="nikitos-admin-dash-card">
                <span class="nikitos-admin-dash-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                </span>
                <span class="nikitos-admin-dash-card__body">
                    <span class="nikitos-admin-dash-card__title">Mensajes de contacto</span>
                    <span class="nikitos-admin-dash-card__desc">Consultas recibidas desde el formulario del sitio.</span>
                </span>
                <span class="nikitos-admin-dash-card__arrow" aria-hidden="true">→</span>
            </a>
        </nav>
    </div>
@endsection

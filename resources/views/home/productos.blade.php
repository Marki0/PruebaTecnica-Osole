@extends('layouts.landing')

@section('title', ($category ?? null) ? $category->name.' — Productos' : 'Productos — Nikitos Snacks')

@section('content')
    @if (! $nikitosPublicLinked)
        <div class="nk-banner-warn nk-wrap" style="margin-top:0.5rem;">
            <p>Ejecutá <code>php artisan nikitos:link-assets</code> para ver imágenes de la carpeta Nikitos.</p>
        </div>
    @endif

    <section class="nk-productos-hero nk-bleed-under-header" aria-label="Productos">
        <div class="nk-productos-hero__media">
            <img src="{{ \App\Support\Landing::sectionHeroImageUrl($heroBanner ?? null, \App\Models\Banner::PLACEMENT_SECTION_PRODUCTOS) }}" alt="" loading="eager" width="1600" height="900">
        </div>
        <div class="nk-productos-hero__overlay" aria-hidden="true"></div>
        <div class="nk-productos-hero__inner nk-wrap">
            <h1 class="nk-productos-hero__title">Productos</h1>
        </div>
    </section>

    @unless ($category)
        <section class="nk-productos-lines" aria-label="Líneas de producto">
            <div class="nk-wrap">
                <div class="nk-productos-grid">
                    @forelse ($catalogCategories as $cat)
                        <a
                            href="{{ route('productos.category', $cat) }}"
                            class="nk-productos-card"
                            style="--card-tone: {{ \App\Support\Landing::categoryAccent($cat) }};"
                        >
                            <img class="nk-productos-card__img" src="{{ \App\Support\Landing::categoryCardImageUrl($cat) }}" alt="" loading="lazy" width="400" height="280">
                            <span class="nk-productos-card__label">{{ $cat->name }}</span>
                            <span class="nk-productos-card__link">Ver productos</span>
                        </a>
                    @empty
                        <p class="nk-catalogo__lead" style="grid-column: 1 / -1;">No hay categorías. Cargalas desde el panel admin.</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endunless

    @if ($category)
        <div class="nk-productos-sheet" aria-hidden="true"></div>
        <section class="nk-catalogo nk-catalogo--productos-category" aria-label="{{ $category->name }}">
            <div class="nk-productos-category-layout nk-wrap">
                <aside class="nk-productos-sidebar" aria-label="Categorías">
                    <nav class="nk-productos-sidebar__nav">
                        @foreach ($catalogCategories as $cat)
                            <a
                                href="{{ route('productos.category', $cat) }}"
                                class="nk-productos-sidebar__link {{ $category->is($cat) ? 'is-active' : '' }}"
                                style="--accent: {{ \App\Support\Landing::categoryAccent($cat) }};"
                            >
                                <span class="nk-productos-sidebar__bar" aria-hidden="true"></span>
                                <span class="nk-productos-sidebar__label">{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    </nav>
                    <p class="nk-productos-sidebar__all-wrap">
                        <a href="{{ route('productos') }}" class="nk-productos-sidebar__all">← Todas las categorías</a>
                    </p>
                </aside>
                <div class="nk-productos-category-main">
                    <div class="nk-productos-category-toolbar">
                        <a href="{{ asset(config('nikitos_home.catalog_pdf')) }}" download="{{ config('nikitos_home.catalog_download_filename') }}" class="nk-catalogo-download">Descargar catálogo</a>
                    </div>

                    @if ($category->products->isEmpty())
                        <p class="nk-catalogo__lead" style="margin:0;">Próximamente productos en esta categoría.</p>
                    @else
                        <div class="nk-product-tiles">
                            @foreach ($category->products as $product)
                                <article
                                    class="nk-card nk-product-tile nk-open-modal"
                                    role="button"
                                    tabindex="0"
                                    style="--cat-accent: {{ \App\Support\Landing::categoryAccent($category) }};"
                                    data-title="{{ e($product->name) }}"
                                    data-desc="{{ e(preg_replace('/\s+/u', ' ', trim((string) ($product->description ?? '')))) }}"
                                    data-img="{{ e(\App\Support\Landing::productImageUrl($product)) }}"
                                >
                                    <div class="nk-card__img">
                                        <img src="{{ \App\Support\Landing::productImageUrl($product) }}" alt="{{ $product->name }}" loading="lazy" width="200" height="200">
                                    </div>
                                    <div class="nk-card__body">
                                        <span class="nk-product-tile__cat">{{ $category->name }}</span>
                                        <h4>{{ $product->name }}</h4>
                                    </div>
                                    <span class="nk-product-tile__link">Ver producto</span>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endsection


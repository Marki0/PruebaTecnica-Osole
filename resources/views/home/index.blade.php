@extends('layouts.landing')

@section('title', 'Nikitos Snacks — Inicio')

@section('content')
    @if (! $nikitosPublicLinked && ! $heroBackgroundImage)
        <div class="nk-banner-warn nk-wrap">
            <p>
                Falta la carpeta <code>public/nikitos/</code> (minúsculas) con los PNG del diseño, o no está en el clone: subila al repo con <code>git add public/nikitos</code> y <code>git push</code>.
            </p>
        </div>
    @endif

    <div class="nk-home nk-bleed-under-header">
        <section class="nk-hero nk-hero--home" aria-label="Inicio">
            <div class="nk-hero__stage">
                <div class="nk-hero__bg-wrap" aria-hidden="true">
                    @if ($heroBackgroundImage)
                        <img class="nk-hero__bg" src="{{ $heroBackgroundImage }}" alt="" width="1920" height="1080" fetchpriority="high">
                    @endif
                </div>
                <div class="nk-hero__overlay" aria-hidden="true"></div>
                <div class="nk-hero__content">
                    <div class="nk-wrap nk-hero__content-inner">
                        <h1>Nikitos Snacks</h1>
                        <p class="nk-hero__tagline">{{ optional($sectionSnacks)->body ?? 'Nikitos se encuentra presente en el mercado local desde hace casi 40 años.' }}</p>
                        <div class="nk-hero__actions">
                            <a class="nk-hero__btn nk-hero__btn--solid" href="{{ asset(config('nikitos_home.catalog_pdf')) }}" download="{{ config('nikitos_home.catalog_download_filename') }}">
                                Descargar catálogo
                                <span class="nk-hero__arrow" aria-hidden="true">→</span>
                            </a>
                            <a class="nk-hero__btn nk-hero__btn--ghost" href="{{ route('productos') }}">Ver productos</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="nk-nosotros nk-nosotros--home nk-nosotros--band" aria-labelledby="nk-home-nosotros-title">
            <div
                class="nk-nosotros__band-core"
                style="--nk-nosotros-vector4: url('{{ \App\Support\Landing::nk('Group 3793.png') }}')"
            >
                <div class="nk-wrap nk-nosotros__grid nk-nosotros__grid--band nk-nosotros__grid--band-text-only">
                    <div class="nk-nosotros__copy">
                        <h2 id="nk-home-nosotros-title">{{ optional($sectionNosotros)->title ?? 'Nosotros' }}</h2>
                        <div class="nk-nosotros__body">{!! nl2br(e(optional($sectionNosotros)->body ?? 'Somos una empresa argentina dedicada a elaborar snacks con los más altos estándares de calidad.')) !!}</div>
                        <a class="nk-nosotros__more" href="{{ route('nosotros') }}">Mas info</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="nk-home-linea" aria-labelledby="nk-home-linea-title">
            <div class="nk-wrap">
                <h2 class="nk-linea__title" id="nk-home-linea-title">Líneas de productos</h2>
                <div class="nk-productos-grid">
                    @forelse ($homeLineCategories as $cat)
                        <a
                            href="{{ route('productos.category', $cat) }}"
                            class="nk-productos-card"
                            style="--card-tone: {{ \App\Support\Landing::categoryAccent($cat) }};"
                        >
                            <img class="nk-productos-card__img" src="{{ \App\Support\Landing::categoryCardImageUrl($cat) }}" alt="" loading="lazy" width="400" height="280">
                            <span class="nk-productos-card__label">{{ $cat->name }}</span>
                            <span class="nk-productos-card__link">Ver todos</span>
                        </a>
                    @empty
                        <p class="nk-catalogo__lead" style="grid-column: 1 / -1; margin: 0;">No hay categorías cargadas. Creá categorías desde el panel de administración.</p>
                    @endforelse
                </div>
                <div class="nk-linea__cta-wrap">
                    <a class="nk-linea__cta" href="{{ route('productos') }}">Ver todas</a>
                </div>
            </div>
        </section>

        <section class="nk-destacados nk-destacados--home" aria-labelledby="nk-home-destacados-title">
            <div class="nk-wrap">
                <h2 class="nk-destacados__title nk-home-section-title" id="nk-home-destacados-title">Productos destacados</h2>
                <div class="nk-destacados__grid">
                    @forelse ($featuredProducts as $product)
                        @php
                            $cat = $product->category;
                            $accent = $cat ? \App\Support\Landing::categoryAccent($cat) : '#f2a900';
                        @endphp
                        <article
                            class="nk-feat nk-open-modal"
                            role="button"
                            tabindex="0"
                            data-title="{{ e($product->name) }}"
                            data-desc="{{ e(preg_replace('/\s+/u', ' ', trim((string) ($product->description ?? '')))) }}"
                            data-img="{{ e(\App\Support\Landing::productImageUrl($product)) }}"
                        >
                            <div class="nk-feat__img">
                                <img src="{{ \App\Support\Landing::productImageUrl($product) }}" alt="{{ $product->name }}" loading="lazy" width="200" height="200">
                            </div>
                            <span class="nk-feat__cat" style="color: {{ $accent }};">{{ optional($cat)->name ?? 'Producto' }}</span>
                            <h3 class="nk-feat__name">{{ $product->name }}</h3>
                            <span class="nk-feat__link">Ver producto</span>
                        </article>
                    @empty
                        <p class="nk-catalogo__lead" style="grid-column: 1 / -1; margin: 0;">No hay productos en la base de datos. Ejecutá las migraciones y el seeder.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="nk-recetas nk-recetas--home" aria-labelledby="nk-home-recetas-title">
            <div class="nk-wrap">
                <h2 class="nk-recetas__title nk-home-section-title" id="nk-home-recetas-title">Recetas</h2>
                <div class="nk-recetas__grid">
                    @forelse ($homeRecipes as $recipe)
                        <a href="{{ route('recetas.show', $recipe) }}" class="nk-receta">
                            <div class="nk-receta__img">
                                <img src="{{ \App\Support\Landing::recipeImageUrl($recipe) }}" alt="" loading="lazy">
                            </div>
                            <h3 class="nk-receta__name">{{ $recipe->title }}</h3>
                            <span class="nk-receta__link">Ver receta</span>
                        </a>
                    @empty
                        <p class="nk-catalogo__lead" style="grid-column: 1 / -1; margin: 0;">Próximamente recetas. Publicá recetas desde el panel admin.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection

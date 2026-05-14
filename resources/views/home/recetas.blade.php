@extends('layouts.landing')

@section('title', 'Recetas — Nikitos Snacks')

@section('content')
    @if (! $nikitosPublicLinked)
        <div class="nk-banner-warn nk-wrap" style="margin-top:0.5rem;">
            <p>Ejecutá <code>php artisan nikitos:link-assets</code> para ver imágenes de la carpeta Nikitos.</p>
        </div>
    @endif

    <section class="nk-productos-hero nk-bleed-under-header" aria-label="Recetas">
        <div class="nk-productos-hero__media">
            <img src="{{ \App\Support\Landing::sectionHeroImageUrl($heroBanner ?? null, \App\Models\Banner::PLACEMENT_SECTION_RECETAS) }}" alt="" loading="eager" width="1600" height="900">
        </div>
        <div class="nk-productos-hero__overlay" aria-hidden="true"></div>
        <div class="nk-productos-hero__inner nk-wrap">
            <h1 class="nk-productos-hero__title">{{ optional($sectionRecetas)->title ?? 'Recetas' }}</h1>
        </div>
    </section>

    <section class="nk-recetas nk-recetas--page">
        <div class="nk-wrap">
            @if (optional($sectionRecetas)->body)
                <p class="nk-contacto__lead" style="margin-top: 0;">{{ $sectionRecetas->body }}</p>
            @endif
            <div class="nk-recetas__grid" style="margin-top: 1.5rem;">
                @forelse ($recipes as $recipe)
                    <a href="{{ route('recetas.show', $recipe) }}" class="nk-receta">
                        <div class="nk-receta__img">
                            <img src="{{ \App\Support\Landing::recipeImageUrl($recipe) }}" alt="" loading="lazy">
                        </div>
                        <h3 class="nk-receta__name">{{ $recipe->title }}</h3>
                        <span class="nk-receta__link">Ver receta</span>
                    </a>
                @empty
                    <p class="nk-catalogo__lead" style="grid-column: 1 / -1;">No hay recetas publicadas todavía.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

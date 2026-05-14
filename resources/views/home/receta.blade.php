@extends('layouts.landing')

@section('title', $recipe->title.' — Recetas — Nikitos Snacks')

@php
    $parts = \App\Support\RecipeDisplay::splitBody($recipe->body);
    $ingLines = $parts['ingredients'] ? \App\Support\RecipeDisplay::lines($parts['ingredients']) : [];
    $stepLines = $parts['steps'] ? \App\Support\RecipeDisplay::lines($parts['steps']) : [];
    $metaLines = \App\Support\RecipeDisplay::lines($recipe->excerpt);
    $haveSplit = is_string($recipe->body) && preg_match('/===PREPARACION===/m', $recipe->body);
@endphp

@section('content')
    @if (! $nikitosPublicLinked)
        <div class="nk-banner-warn nk-wrap" style="margin-top:0.5rem;">
            <p>Ejecutá <code>php artisan nikitos:link-assets</code> para ver imágenes de la carpeta Nikitos.</p>
        </div>
    @endif

    <section class="nk-receta-hero" aria-label="Recetas">
        <div class="nk-receta-hero__media">
            <img src="{{ \App\Support\Landing::nk('image (4).png') }}" alt="" loading="eager" width="1600" height="600">
        </div>
        <div class="nk-receta-hero__overlay" aria-hidden="true"></div>
        <div class="nk-receta-hero__inner nk-wrap">
            <h1 class="nk-receta-hero__title">Recetas</h1>
        </div>
    </section>

    <div class="nk-receta-hero-tear nk-receta-hero-tear--light" aria-hidden="true">
        @include('partials.tear-vector4', ['tearSrc' => 'Vector-4.png', 'extraClass' => ''])
    </div>

    <article class="nk-receta-detail">
        <div class="nk-receta-detail__shell nk-wrap">
            <p class="nk-receta-detail__back">
                <a href="{{ route('recetas') }}">← Todas las recetas</a>
            </p>

            <div class="nk-receta-detail__intro">
                <div class="nk-receta-detail__intro-media">
                    @if ($recipe->image_path)
                        <img
                            src="{{ \App\Support\Landing::recipeImageUrl($recipe) }}"
                            alt="{{ $recipe->title }}"
                            loading="eager"
                            width="960"
                            height="640"
                        >
                    @else
                        <div class="nk-receta-detail__intro-placeholder" role="img" aria-label="Sin imagen de receta"></div>
                    @endif
                </div>
                <div class="nk-receta-detail__intro-aside">
                    <h2 class="nk-receta-detail__title">{{ $recipe->title }}</h2>
                    @if (count($metaLines))
                        <div class="nk-receta-detail__meta">
                            @foreach ($metaLines as $m)
                                <p>{{ $m }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="nk-receta-detail__share">
                        <span class="nk-receta-detail__share-label">Comparte esta receta</span>
                        <div class="nk-receta-detail__share-links">
                            <a href="#" class="nk-receta-detail__share-btn" aria-label="Compartir en Facebook">f</a>
                            <a href="#" class="nk-receta-detail__share-btn" aria-label="Compartir en Instagram">in</a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($haveSplit && (count($ingLines) || count($stepLines)))
                <div class="nk-receta-detail__cols">
                    <div class="nk-receta-detail__col">
                        <h3 class="nk-receta-detail__col-h">Ingredientes</h3>
                        @if (count($ingLines))
                            <ul class="nk-receta-detail__checklist">
                                @foreach ($ingLines as $line)
                                    @if (preg_match('/^[^:]+:\s*$/', $line))
                                        <li class="nk-receta-detail__checklist-heading">{{ rtrim($line, ': ') }}</li>
                                    @else
                                        <li>{{ ltrim($line, '-–—• ') }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="nk-receta-detail__col">
                        <h3 class="nk-receta-detail__col-h">Preparación</h3>
                        @if (count($stepLines))
                            <ul class="nk-receta-detail__checklist nk-receta-detail__checklist--steps">
                                @foreach ($stepLines as $line)
                                    @php
                                        $stepLabel = null;
                                        $stepBody = $line;
                                        if (preg_match('/^Paso\s*(\d+)\s*[—:\-]\s*(.+)$/iu', $line, $m)) {
                                            $stepLabel = 'Paso '.$m[1];
                                            $stepBody = $m[2];
                                        } elseif (preg_match('/^(\d+)\.\s*(.+)$/', $line, $m)) {
                                            $stepLabel = 'Paso '.$m[1];
                                            $stepBody = $m[2];
                                        }
                                    @endphp
                                    <li>
                                        @if ($stepLabel)
                                            <strong class="nk-receta-detail__step-n">{{ $stepLabel }}</strong>
                                        @endif
                                        <span class="nk-receta-detail__step-t">{{ $stepBody }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @elseif (count($stepLines))
                <div class="nk-receta-detail__monolith">
                    <ul class="nk-receta-detail__checklist nk-receta-detail__checklist--steps">
                        @foreach ($stepLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </article>
@endsection

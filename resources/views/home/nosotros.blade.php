@extends('layouts.landing')

@section('title', 'Nosotros — Nikitos Snacks')

@section('content')
    @if (! $nikitosPublicLinked)
        <div class="nk-banner-warn nk-wrap" style="margin-top:0.5rem;">
            <p>Los PNG del mockup van en <code>public/nikitos/</code> (minúsculas) y tienen que estar en el repositorio.</p>
        </div>
    @endif

    <div class="nk-nosotros-view nk-bleed-under-header">
        <section class="nk-nosotros-view__hero" aria-label="Nosotros">
            <div class="nk-nosotros-view__hero-media">
                <img src="{{ \App\Support\Landing::sectionHeroImageUrl($heroBanner ?? null, \App\Models\Banner::PLACEMENT_SECTION_NOSOTROS) }}" alt="" loading="eager" width="1400" height="480">
            </div>
            <div class="nk-nosotros-view__hero-overlay" aria-hidden="true"></div>
            <div class="nk-nosotros-view__hero-inner nk-wrap">
                <h1 class="nk-nosotros-view__hero-title">Nosotros</h1>
            </div>
        </section>

        <div class="nk-nosotros-view__tear nk-nosotros-view__tear--light" aria-hidden="true">
            @include('partials.tear-vector4', ['tearSrc' => 'Vector-4.png', 'extraClass' => ''])
        </div>

        <div class="nk-nosotros-view__body">
            @foreach ($nosotrosBlocks as $index => $section)
                @include('partials.nosotros-strip', ['section' => $section, 'index' => $index])
            @endforeach
        </div>
    </div>
@endsection

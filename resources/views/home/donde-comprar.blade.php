@extends('layouts.landing')

@section('title', 'Donde comprar — Nikitos Snacks')

@section('content')
    @if (! $nikitosPublicLinked)
        <div class="nk-banner-warn nk-wrap" style="margin-top:0.5rem;">
            <p>Ejecutá <code>php artisan nikitos:link-assets</code> para ver imágenes de la carpeta Nikitos.</p>
        </div>
    @endif

    <section class="nk-donde-hero" aria-label="Donde comprar">
        <div class="nk-donde-hero__media">
            <img src="{{ \App\Support\Landing::sectionHeroImageUrl($heroBanner ?? null, \App\Models\Banner::PLACEMENT_SECTION_DONDE_COMPRAR) }}" alt="" loading="eager" width="1400" height="400">
        </div>
        <div class="nk-donde-hero__overlay" aria-hidden="true"></div>
        <div class="nk-donde-hero__inner nk-wrap">
            <h1 class="nk-donde-hero__title">Donde comprar</h1>
        </div>
    </section>

    <div class="nk-donde-sheet" aria-hidden="true"></div>

    <section class="nk-donde-main" aria-label="Distribuidores y mapa">
        <div class="nk-wrap nk-donde-main__grid">
            <div class="nk-donde-panel">
                <form class="nk-donde-filters" id="nk-donde-filters" action="#" method="get" onsubmit="return false;">
                    <label class="nk-donde-filters__field">
                        <span class="nk-donde-filters__label">Provincia</span>
                        <select class="nk-donde-filters__select" id="nk-donde-provincia" name="provincia" aria-label="Provincia">
                            <option value="">Todas</option>
                            @foreach (collect($dondeDistribuidores)->pluck('province')->unique()->sort()->values() as $prov)
                                <option value="{{ $prov }}">{{ $prov }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="nk-donde-filters__field">
                        <span class="nk-donde-filters__label">Ciudad</span>
                        <select class="nk-donde-filters__select" id="nk-donde-ciudad" name="ciudad" aria-label="Ciudad">
                            <option value="">Todas</option>
                        </select>
                    </label>
                    <button type="button" class="nk-donde-filters__submit" id="nk-donde-buscar" aria-label="Buscar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="M21 21l-4.3-4.3"/>
                        </svg>
                    </button>
                </form>

                <ul class="nk-donde-list" id="nk-donde-list">
                    @foreach ($dondeDistribuidores as $row)
                        <li
                            class="nk-donde-list__item"
                            data-province="{{ e($row['province']) }}"
                            data-city="{{ e($row['city']) }}"
                        >
                            <span class="nk-donde-list__name">{{ $row['name'] }}</span>
                            <span class="nk-donde-list__meta">{{ $row['city'] }} · {{ $row['province'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="nk-donde-map-wrap">
                <div class="nk-donde-map">
                    <img
                        class="nk-donde-map__img"
                        src="{{ \App\Support\Landing::nk('Mask group (1).png') }}"
                        alt="Mapa de referencia de puntos de venta en el Gran Buenos Aires"
                        loading="lazy"
                        width="1200"
                        height="900"
                    >
                    <div class="nk-donde-map__pins" aria-hidden="true">
                        <span class="nk-donde-map__pin" style="top: 38%; left: 52%;"></span>
                        <span class="nk-donde-map__pin" style="top: 48%; left: 68%;"></span>
                        <span class="nk-donde-map__pin" style="top: 58%; left: 44%;"></span>
                        <span class="nk-donde-map__pin" style="top: 44%; left: 36%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    var rows = @json($dondeDistribuidores);
    var provSel = document.getElementById('nk-donde-provincia');
    var citySel = document.getElementById('nk-donde-ciudad');
    var list = document.getElementById('nk-donde-list');
    var btn = document.getElementById('nk-donde-buscar');
    if (!provSel || !citySel || !list) return;

    function citiesForProvince(p) {
        if (!p) {
            return rows.map(function (r) { return r.city; }).filter(function (c, i, a) { return a.indexOf(c) === i; }).sort();
        }
        return rows.filter(function (r) { return r.province === p; }).map(function (r) { return r.city; })
            .filter(function (c, i, a) { return a.indexOf(c) === i; }).sort();
    }

    function fillCities() {
        var p = provSel.value;
        var cities = citiesForProvince(p);
        var prev = citySel.value;
        citySel.innerHTML = '<option value="">Todas</option>';
        cities.forEach(function (c) {
            var o = document.createElement('option');
            o.value = c;
            o.textContent = c;
            citySel.appendChild(o);
        });
        if (prev && cities.indexOf(prev) !== -1) citySel.value = prev;
    }

    function applyFilter() {
        var p = provSel.value;
        var c = citySel.value;
        list.querySelectorAll('.nk-donde-list__item').forEach(function (li) {
            var okP = !p || li.getAttribute('data-province') === p;
            var okC = !c || li.getAttribute('data-city') === c;
            li.style.display = okP && okC ? '' : 'none';
        });
    }

    provSel.addEventListener('change', function () {
        fillCities();
        applyFilter();
    });
    citySel.addEventListener('change', applyFilter);
    if (btn) btn.addEventListener('click', applyFilter);
    fillCities();
})();
</script>
@endpush

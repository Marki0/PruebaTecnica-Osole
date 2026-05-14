@php
    /** @var int $index 0..3 */
    /** @var \App\Models\SiteSection|null $section */
    $isAlt = $index % 2 === 1;
    $headingId = 'nk-nosotros-bloque-'.$index;
    $extra = $section?->extra ?? [];
    $imgAlt = ! empty($extra['image_alt']) ? (string) $extra['image_alt'] : '';
    $title = $section?->title ?? '';
@endphp
<section
    class="nk-nosotros-view__strip{{ $isAlt ? ' nk-nosotros-view__strip--alt' : '' }}"
    aria-labelledby="{{ $headingId }}"
>
    <div class="nk-wrap nk-nosotros-view__strip-inner{{ $isAlt ? ' nk-nosotros-view__strip-inner--flip' : '' }}">
        <div class="nk-nosotros-view__text">
            <h2 id="{{ $headingId }}">{{ $title !== '' ? $title : '—' }}</h2>
            @foreach (\App\Support\NosotrosPage::bodyParagraphs($section?->body) as $para)
                <p>{{ $para }}</p>
            @endforeach
        </div>
        <figure class="nk-nosotros-view__figure">
            <img src="{{ \App\Support\Landing::nosotrosBlockFigureUrl($section, $index) }}" alt="{{ $imgAlt }}" loading="lazy" width="900" height="600">
        </figure>
    </div>
</section>

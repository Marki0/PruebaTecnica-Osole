@php
    $tearSrc = $tearSrc ?? 'Group 3793.png';
    $extraClass = $extraClass ?? '';
    $flipVertical = $flipVertical ?? false;
@endphp
<div class="nk-tear nk-tear--vector4 {{ $flipVertical ? 'nk-tear--vector4--flip' : '' }} {{ $extraClass }}" aria-hidden="true">
    <img src="{{ \App\Support\Landing::nk($tearSrc) }}" alt="" width="1920" height="160" decoding="async" loading="lazy">
</div>

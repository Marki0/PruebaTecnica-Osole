<div>
    <label for="title">Título</label>
    <input id="title" type="text" name="title" value="{{ old('title', $banner->title ?? '') }}" maxlength="255">
</div>
<div>
    <label for="subtitle">Subtítulo</label>
    <input id="subtitle" type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}" maxlength="500">
</div>
<div>
    <label for="link_url">Enlace (URL)</label>
    <input id="link_url" type="text" name="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}" maxlength="2048" placeholder="https://">
</div>
<div>
    <label for="placement">Ubicación</label>
    <select id="placement" name="placement" required style="width:100%;max-width:36rem;padding:0.55rem 0.75rem;border:1px solid #e8e8e8;border-radius:8px;font:inherit;">
        @php $pl = old('placement', $banner->placement ?? 'hero'); @endphp
        <option value="hero" {{ $pl === 'hero' ? 'selected' : '' }}>hero (principal)</option>
        <option value="home" {{ $pl === 'home' ? 'selected' : '' }}>home</option>
        <option value="promo" {{ $pl === 'promo' ? 'selected' : '' }}>promo</option>
    </select>
</div>
<div>
    <label for="sort_order">Orden</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0" max="65535">
</div>
<div>
    <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
        Activo
    </label>
</div>
<div>
    <label for="image">Imagen</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <p class="muted" style="margin:0.25rem 0 0;">Opcional al crear. JPEG/PNG/WebP, máx. 3 MB. Se optimiza al subir.</p>
    @if (! empty($banner?->image_path))
        <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <img src="{{ asset('storage/'.$banner->image_path) }}" alt="" class="admin-thumb" style="width:96px;height:96px;">
            <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
                <input type="checkbox" name="remove_image" value="1" {{ old('remove_image') ? 'checked' : '' }}>
                Quitar imagen
            </label>
        </div>
    @endif
</div>

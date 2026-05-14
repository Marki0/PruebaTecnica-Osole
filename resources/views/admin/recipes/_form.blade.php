@php
    /** @var \App\Models\Recipe|null $recipe */
@endphp

<div>
    <label for="title">Título</label>
    <input id="title" type="text" name="title" value="{{ old('title', $recipe->title ?? '') }}" required maxlength="255">
</div>

<div>
    <label for="slug">Slug (opcional)</label>
    <input id="slug" type="text" name="slug" value="{{ old('slug', $recipe->slug ?? '') }}" maxlength="255" placeholder="mi-receta">
    <p class="muted" style="margin:0.25rem 0 0;">Si lo dejás vacío, se genera desde el título.</p>
</div>

<div>
    <label for="excerpt">Resumen</label>
    <textarea id="excerpt" name="excerpt" maxlength="500" rows="3">{{ old('excerpt', $recipe->excerpt ?? '') }}</textarea>
    <p class="muted" style="margin:0.35rem 0 0;">En la ficha pública: una línea por dato (ej. tiempo de preparación y porciones).</p>
</div>

<div>
    <label for="body">Contenido</label>
    <textarea id="body" name="body" maxlength="100000" rows="10">{{ old('body', $recipe->body ?? '') }}</textarea>
    <p class="muted" style="margin:0.35rem 0 0;">Para la ficha pública en dos columnas (Ingredientes / Preparación), usá una línea exacta <code>===PREPARACION===</code>: arriba los ítems (una línea por ingrediente; líneas que terminan en «:» como subtítulo, ej. <code>Para el pescado:</code>); abajo los pasos (ej. <code>Paso 1 — texto</code> o <code>1. texto</code>).</p>
</div>

<div>
    <label for="sort_order">Orden</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $recipe->sort_order ?? 0) }}" min="0" max="65535">
</div>

<div>
    <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', optional($recipe)->is_published) ? 'checked' : '' }}>
        Publicada (visible en el sitio)
    </label>
</div>

<div>
    <label for="image">Imagen</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <p class="muted" style="margin:0.25rem 0 0;">JPEG/PNG/WebP, máx. 2 MB. Se optimiza al subir.</p>
    @if (! empty($recipe?->image_path))
        <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <img src="{{ asset('storage/'.$recipe->image_path) }}" alt="" class="admin-thumb" style="width:96px;height:96px;">
            <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
                <input type="checkbox" name="remove_image" value="1" {{ old('remove_image') ? 'checked' : '' }}>
                Quitar imagen
            </label>
        </div>
    @endif
</div>

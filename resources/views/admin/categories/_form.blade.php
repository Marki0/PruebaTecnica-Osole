@php
    /** @var \App\Models\Category|null $category */
@endphp

<div>
    <label for="name">Nombre</label>
    <input id="name" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required maxlength="255">
</div>

<div>
    <label for="slug">Slug (opcional)</label>
    <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" maxlength="255" placeholder="mi-linea-de-productos">
    <p class="muted" style="margin:0.25rem 0 0;">Solo letras, números y guiones. Si lo dejás vacío al crear, se arma desde el nombre.</p>
</div>

<div>
    <label for="description">Descripción</label>
    <textarea id="description" name="description" maxlength="5000">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div>
    <label for="sort_order">Orden</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0" max="65535">
    <p class="muted" style="margin:0.25rem 0 0;">Menor número = aparece antes en listados.</p>
</div>

<div>
    <label for="accent_color">Color de acento (hex)</label>
    <input id="accent_color" type="text" name="accent_color" value="{{ old('accent_color', $category->accent_color ?? '') }}" maxlength="32" placeholder="#f2a900">
    <p class="muted" style="margin:0.25rem 0 0;">Opcional. Formato <code>#RGB</code> o <code>#RRGGBB</code>. Se usa en tarjetas y destacados.</p>
</div>

<div>
    <label for="image">Imagen</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <p class="muted" style="margin:0.25rem 0 0;">JPEG, PNG o WebP. Máx. 2 MB. Se optimiza al subir (ancho máx. 1200px).</p>
    @if (! empty($category?->image_path))
        <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <img src="{{ asset('storage/'.$category->image_path) }}" alt="" class="admin-thumb" style="width:96px;height:96px;">
            <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
                <input type="checkbox" name="remove_image" value="1" {{ old('remove_image') ? 'checked' : '' }}>
                Quitar imagen actual
            </label>
        </div>
    @endif
</div>

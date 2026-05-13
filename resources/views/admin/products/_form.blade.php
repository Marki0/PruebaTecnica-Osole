@php
    /** @var \App\Models\Product|null $product */
    $categories = $categories ?? collect();
@endphp

<div>
    <label for="category_id">Categoría</label>
    <select id="category_id" name="category_id" required style="width:100%;max-width:32rem;padding:0.5rem;border:1px solid #d4d4d8;border-radius:6px;font:inherit;">
        <option value="">— Elegir —</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ (int) old('category_id', $product->category_id ?? 0) === $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

<div>
    <label for="name">Nombre</label>
    <input id="name" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required maxlength="255">
</div>

<div>
    <label for="slug">Slug (opcional)</label>
    <input id="slug" type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" maxlength="255" placeholder="mi-producto">
    <p class="muted" style="margin:0.25rem 0 0;">Si lo dejás vacío al crear, se genera desde el nombre.</p>
</div>

<div>
    <label for="description">Descripción</label>
    <textarea id="description" name="description" maxlength="10000">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div>
    <label for="sort_order">Orden</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0" max="65535">
</div>

<div>
    <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
        Producto destacado
    </label>
</div>

<div>
    <label for="image">Imagen principal</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    <p class="muted" style="margin:0.25rem 0 0;">JPEG, PNG o WebP. Máx. 2 MB. Se optimiza al subir.</p>
    @if (! empty($product?->primaryImage))
        <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <img src="{{ asset('storage/'.$product->primaryImage->path) }}" alt="" class="admin-thumb" style="width:96px;height:96px;">
            <label style="font-weight:400;display:flex;align-items:center;gap:0.35rem;">
                <input type="checkbox" name="remove_primary" value="1" {{ old('remove_primary') ? 'checked' : '' }}>
                Quitar imagen principal
            </label>
        </div>
    @endif
</div>

<div>
    <label for="gallery">Galería (opcional, varias)</label>
    <input id="gallery" type="file" name="gallery[]" accept="image/jpeg,image/png,image/webp" multiple>
    <p class="muted" style="margin:0.25rem 0 0;">Podés seleccionar varias. Máx. 12 archivos por envío, 2 MB c/u.</p>
</div>

@if (! empty($product))
    @php
        $galleryImages = $product->images->where('is_primary', false)->values();
    @endphp
    @if ($galleryImages->isNotEmpty())
        <div>
            <span style="font-weight:600;font-size:0.9rem;">Imágenes de galería</span>
            <ul style="list-style:none;padding:0;margin:0.5rem 0 0;display:flex;flex-wrap:wrap;gap:0.75rem;">
                @foreach ($galleryImages as $gimg)
                    <li style="text-align:center;">
                        <img src="{{ asset('storage/'.$gimg->path) }}" alt="" class="admin-thumb" style="width:72px;height:72px;display:block;margin:0 auto 0.35rem;">
                        <form action="{{ route('admin.products.images.destroy', [$product, $gimg]) }}" method="post" onsubmit="return confirm('¿Eliminar esta imagen?');" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endif

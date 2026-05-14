@extends('layouts.admin')

@php
    $isNosotrosBlock = in_array($site_section->key, \App\Models\SiteSection::NOSOTROS_PAGE_BLOCK_KEYS, true);
    $extra = $site_section->extra ?? [];
@endphp

@section('title', 'Editar texto')

@section('content')
    <h1 style="margin-top:0;">Editar sección</h1>
    <p class="muted" style="margin-top:0;">Clave: <code>{{ $site_section->key }}</code></p>

    <form action="{{ route('admin.site-sections.update', $site_section) }}" method="post" class="form-stack" style="max-width:40rem;" @if ($isNosotrosBlock) enctype="multipart/form-data" @endif>
        @csrf
        @method('PUT')
        <div>
            <label for="title">Título</label>
            <input id="title" type="text" name="title" value="{{ old('title', $site_section->title) }}" maxlength="255">
        </div>
        <div>
            <label for="body">Texto</label>
            @if ($isNosotrosBlock)
                <p class="muted" style="margin:0 0 0.35rem;">Para varios párrafos en este bloque, dejá <strong>una línea en blanco</strong> entre párrafo y párrafo.</p>
            @endif
            <textarea id="body" name="body" maxlength="50000" style="min-height:{{ $isNosotrosBlock ? '18rem' : '12rem' }};">{{ old('body', $site_section->body) }}</textarea>
        </div>
        @if ($isNosotrosBlock)
            <div>
                <label for="image">Imagen subida (opcional)</label>
                @if (! empty($extra['image_path']))
                    <p class="muted" style="margin:0 0 0.35rem;">Actual: <a href="{{ asset('storage/'.$extra['image_path']) }}" target="_blank" rel="noopener">ver archivo</a></p>
                @endif
                <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
                <p class="muted" style="margin:0.25rem 0 0;">JPEG, PNG o WebP, máx. 2 MB. Si subís una imagen, se muestra en la web en lugar del archivo Nikitos hasta que la quites.</p>
            </div>
            @if (! empty($extra['image_path']))
                <div>
                    <label style="display:flex;align-items:center;gap:0.5rem;font-weight:normal;">
                        <input type="checkbox" name="remove_block_image" value="1" @checked(old('remove_block_image'))>
                        Quitar imagen subida (vuelve a Nikitos o al default del bloque)
                    </label>
                </div>
            @endif
            <div>
                <label for="nikitos_image">Imagen Nikitos (archivo en carpeta <code>public/nikitos/</code>)</label>
                <input id="nikitos_image" type="text" name="nikitos_image" value="{{ old('nikitos_image', $extra['nikitos_image'] ?? '') }}" maxlength="255" placeholder="ej. Group 3798.png">
                <p class="muted" style="margin:0.25rem 0 0;">Solo aplica si no hay imagen subida. Si lo dejás vacío, se usa la imagen por defecto de este bloque.</p>
            </div>
            <div>
                <label for="image_alt">Texto alternativo de la imagen (accesibilidad)</label>
                <input id="image_alt" type="text" name="image_alt" value="{{ old('image_alt', $extra['image_alt'] ?? '') }}" maxlength="500">
            </div>
        @endif
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.site-sections.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

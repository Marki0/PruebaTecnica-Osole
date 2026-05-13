@extends('layouts.admin')

@section('title', 'Editar texto')

@section('content')
    <h1 style="margin-top:0;">Editar sección</h1>
    <p class="muted" style="margin-top:0;">Clave: <code>{{ $site_section->key }}</code></p>

    <form action="{{ route('admin.site-sections.update', $site_section) }}" method="post" class="form-stack" style="max-width:40rem;">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Título</label>
            <input id="title" type="text" name="title" value="{{ old('title', $site_section->title) }}" maxlength="255">
        </div>
        <div>
            <label for="body">Texto</label>
            <textarea id="body" name="body" maxlength="50000" style="min-height:12rem;">{{ old('body', $site_section->body) }}</textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.site-sections.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

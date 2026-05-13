@extends('layouts.admin')

@section('title', 'Nueva categoría')

@section('content')
    <h1 style="margin-top:0;">Nueva categoría</h1>
    <p class="muted" style="margin-top:0;">El slug se genera solo si lo dejás vacío (a partir del nombre).</p>

    <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data" class="form-stack">
        @csrf
        @include('admin.categories._form', ['category' => null])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection

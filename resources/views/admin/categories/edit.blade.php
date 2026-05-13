@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')
    <h1 style="margin-top:0;">Editar categoría</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="post" enctype="multipart/form-data" class="form-stack">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category])

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

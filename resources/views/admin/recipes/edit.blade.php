@extends('layouts.admin')

@section('title', 'Editar receta')

@section('content')
    <h1 style="margin-top:0;">Editar receta</h1>
    <form action="{{ route('admin.recipes.update', $recipe) }}" method="post" enctype="multipart/form-data" class="form-stack" style="max-width:40rem;">
        @csrf
        @method('PUT')
        @include('admin.recipes._form', ['recipe' => $recipe])
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

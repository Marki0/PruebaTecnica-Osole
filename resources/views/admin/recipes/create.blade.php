@extends('layouts.admin')

@section('title', 'Nueva receta')

@section('content')
    <h1 style="margin-top:0;">Nueva receta</h1>
    <form action="{{ route('admin.recipes.store') }}" method="post" enctype="multipart/form-data" class="form-stack" style="max-width:40rem;">
        @csrf
        @include('admin.recipes._form', ['recipe' => null])
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection

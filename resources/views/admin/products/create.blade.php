@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')
    <h1 style="margin-top:0;">Nuevo producto</h1>

    @if ($categories->isEmpty())
        <p class="admin-flash admin-flash--err">No hay categorías. <a href="{{ route('admin.categories.create') }}">Creá una categoría</a> antes de cargar productos.</p>
    @else
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" class="form-stack">
            @csrf
            @include('admin.products._form', ['product' => null])

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    @endif
@endsection

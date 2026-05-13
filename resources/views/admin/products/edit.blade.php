@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')
    <h1 style="margin-top:0;">Editar producto</h1>

    @if ($categories->isEmpty())
        <p class="admin-flash admin-flash--err">No hay categorías disponibles.</p>
    @else
        <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data" class="form-stack">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['product' => $product])

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    @endif
@endsection

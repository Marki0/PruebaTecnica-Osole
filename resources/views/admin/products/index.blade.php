@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h1 style="margin:0;">Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Nuevo producto</a>
    </div>

    @if ($products->isEmpty())
        <p class="muted">No hay productos. <a href="{{ route('admin.products.create') }}">Crear el primero</a> (necesitás al menos una <a href="{{ route('admin.categories.index') }}">categoría</a>).</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:64px;"></th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Slug</th>
                    <th>Destacado</th>
                    <th>Orden</th>
                    <th style="width:160px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->primaryImage)
                                <img class="admin-thumb" src="{{ asset('storage/'.$product->primaryImage->path) }}" alt="">
                            @else
                                <div class="admin-thumb" aria-hidden="true"></div>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td><code style="font-size:0.85rem;">{{ $product->slug }}</code></td>
                        <td>{{ $product->is_featured ? 'Sí' : '—' }}</td>
                        <td>{{ $product->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar este producto y todas sus imágenes?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:1rem;">
            {{ $products->links() }}
        </div>
    @endif
@endsection

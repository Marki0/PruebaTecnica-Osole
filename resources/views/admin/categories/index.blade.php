@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h1 style="margin:0;">Categorías</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Nueva categoría</a>
    </div>

    @if ($categories->isEmpty())
        <p class="muted">No hay categorías. Creá la primera.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:64px;"></th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Productos</th>
                    <th>Orden</th>
                    <th style="width:140px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            @if ($category->image_path)
                                <img class="admin-thumb" src="{{ asset('storage/'.$category->image_path) }}" alt="">
                            @else
                                <div class="admin-thumb" aria-hidden="true"></div>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td><code style="font-size:0.85rem;">{{ $category->slug }}</code></td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría? Se eliminarán sus productos asociados.');">
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
            {{ $categories->links() }}
        </div>
    @endif
@endsection

@extends('layouts.admin')

@section('title', 'Recetas')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h1 style="margin:0;">Recetas</h1>
        <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary">Nueva receta</a>
    </div>

    @if ($recipes->isEmpty())
        <p class="muted">No hay recetas. <a href="{{ route('admin.recipes.create') }}">Crear la primera</a>.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:64px;"></th>
                    <th>Título</th>
                    <th>Slug</th>
                    <th>Publicada</th>
                    <th>Orden</th>
                    <th style="width:160px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recipes as $recipe)
                    <tr>
                        <td>
                            @if ($recipe->image_path)
                                <img class="admin-thumb" src="{{ asset('storage/'.$recipe->image_path) }}" alt="">
                            @else
                                <div class="admin-thumb" aria-hidden="true"></div>
                            @endif
                        </td>
                        <td>{{ $recipe->title }}</td>
                        <td><code style="font-size:0.85rem;">{{ $recipe->slug }}</code></td>
                        <td>{{ $recipe->is_published ? 'Sí' : 'No' }}</td>
                        <td>{{ $recipe->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.recipes.edit', $recipe) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar esta receta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $recipes->links() }}</div>
    @endif
@endsection

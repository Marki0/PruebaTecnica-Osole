@extends('layouts.admin')

@section('title', 'Banners')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
        <h1 style="margin:0;">Banners</h1>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Nuevo banner</a>
    </div>

    @if ($banners->isEmpty())
        <p class="muted">No hay banners.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:72px;"></th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Orden</th>
                    <th>Activo</th>
                    <th style="width:150px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                    <tr>
                        <td>
                            @if ($banner->image_path)
                                <img class="admin-thumb" src="{{ asset('storage/'.$banner->image_path) }}" alt="">
                            @else
                                <div class="admin-thumb"></div>
                            @endif
                        </td>
                        <td>{{ $banner->title ?? '—' }}</td>
                        <td><code>{{ $banner->placement }}</code></td>
                        <td>{{ $banner->sort_order }}</td>
                        <td>{{ $banner->is_active ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar este banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $banners->links() }}</div>
    @endif
@endsection

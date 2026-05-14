@extends('layouts.admin')

@section('title', 'Banners — heroes de sección')

@section('content')
    <h1 style="margin-top:0;">Banners (heroes)</h1>
    <p class="muted" style="margin-top:0;">Cuatro imágenes fijas: una para el hero de <strong>Productos</strong>, <strong>Dónde comprar</strong>, <strong>Nosotros</strong> y <strong>Recetas</strong>. Al guardar cambios, la web usa la imagen activa de cada ubicación.</p>

    <table class="admin-table" style="margin-top:1rem;">
        <thead>
            <tr>
                <th style="width:140px;">Vista previa</th>
                <th>Ubicación en el sitio</th>
                <th>Clave interna</th>
                <th>Estado</th>
                <th style="width:140px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slots as $slot)
                @php
                    /** @var \App\Models\Banner|null $b */
                    $b = $slot['banner'];
                @endphp
                <tr>
                    <td>
                        @if ($b && $b->image_path)
                            <img class="admin-thumb" src="{{ asset('storage/'.$b->image_path) }}" alt="" style="width:120px;height:72px;object-fit:cover;border-radius:6px;">
                        @else
                            <div class="admin-thumb" style="width:120px;height:72px;background:#eee;border-radius:6px;" title="Sin imagen"></div>
                        @endif
                    </td>
                    <td><strong>{{ $slot['label'] }}</strong></td>
                    <td><code>{{ $slot['placement'] }}</code></td>
                    <td>
                        @if ($b)
                            {{ $b->is_active ? 'Activo' : 'Inactivo (se usa imagen de respaldo Nikitos)' }}
                        @else
                            <span class="muted">Sin cargar</span>
                        @endif
                    </td>
                    <td>
                        @if ($b)
                            <a href="{{ route('admin.banners.edit', $b) }}" class="btn btn-secondary btn-sm">Editar</a>
                        @else
                            <a href="{{ route('admin.banners.create', ['placement' => $slot['placement']]) }}" class="btn btn-primary btn-sm">Crear</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="muted" style="margin-top:1.25rem;">No se eliminan filas de sección: usá <strong>Editar</strong> para cambiar la imagen o desactivar el banner.</p>
@endsection

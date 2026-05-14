@extends('layouts.admin')

@section('title', 'Textos y secciones')

@section('content')
    <h1 style="margin-top:0;">Textos y secciones</h1>
    <p class="muted" style="margin-top:0;">Editá los textos que se muestran en la web. La clave interna no se modifica.</p>

    @if ($sections->isEmpty())
        <p class="muted">No hay secciones. Ejecutá <code>php artisan db:seed</code> tras las migraciones.</p>
    @else
        @php
            $sectionLabels = [
                'home_snacks' => 'Hero inicio — texto bajo el título',
                'nosotros' => 'Bloque Nosotros (resumen en la home)',
                'nosotros_bloque_1' => 'Página Nosotros — bloque 1 (¿Quiénes somos?)',
                'nosotros_bloque_2' => 'Página Nosotros — bloque 2 (Planta modelo)',
                'nosotros_bloque_3' => 'Página Nosotros — bloque 3 (El equipo)',
                'nosotros_bloque_4' => 'Página Nosotros — bloque 4 (Flota)',
                'contacto_page' => 'Página Contacto — título y bajada',
                'recetas_page' => 'Página Recetas — título y bajada',
            ];
        @endphp
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Clave</th>
                    <th>Uso</th>
                    <th>Título</th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr>
                        <td><code>{{ $section->key }}</code></td>
                        <td class="muted">{{ $sectionLabels[$section->key] ?? '—' }}</td>
                        <td>{{ $section->title ?? '—' }}</td>
                        <td><a href="{{ route('admin.site-sections.edit', $section) }}" class="btn btn-secondary btn-sm">Editar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

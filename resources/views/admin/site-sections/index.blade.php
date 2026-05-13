@extends('layouts.admin')

@section('title', 'Textos y secciones')

@section('content')
    <h1 style="margin-top:0;">Textos y secciones</h1>
    <p class="muted" style="margin-top:0;">Editá los textos que se muestran en la web. La clave interna no se modifica.</p>

    @if ($sections->isEmpty())
        <p class="muted">No hay secciones. Ejecutá <code>php artisan db:seed</code> tras las migraciones.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Clave</th>
                    <th>Título</th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr>
                        <td><code>{{ $section->key }}</code></td>
                        <td>{{ $section->title ?? '—' }}</td>
                        <td><a href="{{ route('admin.site-sections.edit', $section) }}" class="btn btn-secondary btn-sm">Editar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

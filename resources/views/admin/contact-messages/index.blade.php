@extends('layouts.admin')

@section('title', 'Mensajes de contacto')

@section('content')
    <h1 style="margin-top:0;">Mensajes de contacto</h1>

    @if ($messages->isEmpty())
        <p class="muted">Todavía no hay mensajes desde el formulario de la landing.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $msg)
                    <tr>
                        <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $msg->name }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>{{ $msg->read_at ? 'Leído' : 'Nuevo' }}</td>
                        <td><a href="{{ route('admin.contact-messages.show', $msg) }}" class="btn btn-secondary btn-sm">Ver</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $messages->links() }}</div>
    @endif
@endsection

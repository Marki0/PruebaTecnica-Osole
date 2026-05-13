@extends('layouts.admin')

@section('title', 'Mensaje de contacto')

@section('content')
    <p class="muted" style="margin:0 0 1rem;"><a href="{{ route('admin.contact-messages.index') }}">← Volver al listado</a></p>
    <h1 style="margin-top:0;">Mensaje #{{ $contact_message->id }}</h1>

    <dl style="margin:0;line-height:1.7;">
        <dt class="muted" style="font-size:0.85rem;">Fecha</dt>
        <dd style="margin:0 0 0.75rem;">{{ $contact_message->created_at->format('d/m/Y H:i') }}</dd>
        <dt class="muted" style="font-size:0.85rem;">Nombre</dt>
        <dd style="margin:0 0 0.75rem;">{{ $contact_message->name }}</dd>
        <dt class="muted" style="font-size:0.85rem;">Email</dt>
        <dd style="margin:0 0 0.75rem;"><a href="mailto:{{ $contact_message->email }}">{{ $contact_message->email }}</a></dd>
        @if ($contact_message->phone)
            <dt class="muted" style="font-size:0.85rem;">Teléfono</dt>
            <dd style="margin:0 0 0.75rem;">{{ $contact_message->phone }}</dd>
        @endif
        <dt class="muted" style="font-size:0.85rem;">Mensaje</dt>
        <dd style="margin:0;white-space:pre-wrap;">{{ $contact_message->message }}</dd>
    </dl>
@endsection

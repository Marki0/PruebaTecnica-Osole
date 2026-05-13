@extends('layouts.app')

@section('title', 'Nikitos — Inicio')

@section('content')
    <header style="padding:1rem 1.5rem;border-bottom:1px solid #e4e4e7;">
        <strong>Nikitos</strong>
        <span style="margin-left:1rem;color:#71717a;">Landing en construcción</span>
        <a href="{{ route('login') }}" style="float:right;color:#2563eb;">Acceso admin</a>
    </header>
    <main style="max-width:42rem;margin:2rem auto;padding:0 1rem;">
        @if (session('status'))
            <p style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:8px;">{{ session('status') }}</p>
        @endif
        <h1 style="margin-top:0;">Nikitos Snacks</h1>
        <p>Proyecto base Laravel: maquetación Figma y panel de administración en desarrollo.</p>

        <h2>Contacto (prueba)</h2>
        <form action="{{ route('contact.store') }}" method="post" style="display:grid;gap:0.75rem;">
            @csrf
            <div>
                <label for="name">Nombre</label><br>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required style="width:100%;max-width:24rem;padding:0.5rem;">
                @error('name')<small style="color:#b91c1c;">{{ $message }}</small>@enderror
            </div>
            <div>
                <label for="email">Email</label><br>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required style="width:100%;max-width:24rem;padding:0.5rem;">
                @error('email')<small style="color:#b91c1c;">{{ $message }}</small>@enderror
            </div>
            <div>
                <label for="phone">Teléfono (opcional)</label><br>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" style="width:100%;max-width:24rem;padding:0.5rem;">
                @error('phone')<small style="color:#b91c1c;">{{ $message }}</small>@enderror
            </div>
            <div>
                <label for="message">Mensaje</label><br>
                <textarea id="message" name="message" rows="4" required style="width:100%;max-width:24rem;padding:0.5rem;">{{ old('message') }}</textarea>
                @error('message')<small style="color:#b91c1c;">{{ $message }}</small>@enderror
            </div>
            <button type="submit" style="width:fit-content;padding:0.5rem 1rem;background:#18181b;color:#fff;border:0;border-radius:6px;cursor:pointer;">Enviar</button>
        </form>
    </main>
@endsection

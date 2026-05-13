@extends('layouts.auth-nikitos')

@section('title', 'Iniciar sesión — Admin')

@section('content')
    <div class="nikitos-auth-card">
        <a href="{{ route('home') }}" class="nikitos-auth-logo">Nikitos <span>snacks</span></a>
        <h1>Panel administrador</h1>
        <p class="muted" style="margin:0 0 1.25rem;">Ingresá con tu cuenta de administración.</p>

        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="nikitos-auth-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <p style="color:#b91c1c;font-size:0.85rem;margin:0.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div class="nikitos-auth-field">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" required autocomplete="current-password">
            </div>
            <label class="nikitos-auth-remember">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Recordarme
            </label>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

        <p class="nikitos-auth-footer"><a href="{{ route('home') }}">Volver al sitio</a></p>
    </div>
@endsection

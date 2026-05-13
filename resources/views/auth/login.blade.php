@extends('layouts.app')

@section('title', 'Iniciar sesión — Admin')

@section('content')
    <main style="max-width:22rem;margin:3rem auto;padding:0 1rem;">
        <h1 style="margin-top:0;">Panel administrador</h1>
        <form method="post" action="{{ route('login') }}" style="display:grid;gap:1rem;">
            @csrf
            <div>
                <label for="email">Email</label><br>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" style="width:100%;padding:0.5rem;box-sizing:border-box;">
                @error('email')<p style="color:#b91c1c;font-size:0.875rem;margin:0.25rem 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password">Contraseña</label><br>
                <input id="password" name="password" type="password" required autocomplete="current-password" style="width:100%;padding:0.5rem;box-sizing:border-box;">
            </div>
            <label style="display:flex;align-items:center;gap:0.5rem;">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Recordarme
            </label>
            <button type="submit" style="padding:0.6rem 1rem;background:#18181b;color:#fff;border:0;border-radius:6px;cursor:pointer;">Entrar</button>
        </form>
        <p style="margin-top:1.5rem;"><a href="{{ route('home') }}">Volver al sitio</a></p>
    </main>
@endsection

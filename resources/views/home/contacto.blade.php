@extends('layouts.landing')

@section('title', 'Contacto — Nikitos Snacks')

@section('content')
    <section class="nk-contacto nk-contacto--page" id="contacto">
        <div class="nk-wrap nk-contact-grid">
            <div>
                <h1 class="nk-contacto__title">{{ optional($sectionContacto)->title ?? 'Contacto' }}</h1>
                <p class="nk-contacto__lead">{{ optional($sectionContacto)->body ?? 'Escribinos y te respondemos a la brevedad.' }}</p>
            </div>
            <div>
                @if (session('status'))
                    <div class="nk-alert nk-alert--ok">{{ session('status') }}</div>
                @endif
                <form class="nk-form" action="{{ route('contact.store') }}" method="post">
                    @csrf
                    <div class="nk-form__field">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')<span class="nk-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="nk-form__field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<span class="nk-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="nk-form__field">
                        <label for="phone">Teléfono <em>(opcional)</em></label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel">
                        @error('phone')<span class="nk-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="nk-form__field">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')<span class="nk-field-error">{{ $message }}</span>@enderror
                    </div>
                    <button class="nk-btn nk-btn--send" type="submit">Enviar mensaje</button>
                </form>
            </div>
        </div>
    </section>
@endsection

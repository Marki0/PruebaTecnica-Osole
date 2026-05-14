@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
    <h1 style="margin-top:0;">Panel</h1>
    <p class="muted" style="margin-top:0;">Gestioná textos, banners, categorías, productos, recetas y mensajes de contacto desde el menú superior. La arquitectura del back-end está resumida en <code>docs/backend-arquitectura.md</code>.</p>
    <ul style="line-height:1.9;margin:0;padding-left:1.2rem;">
        <li><a href="{{ route('admin.site-sections.index') }}">Textos y secciones</a></li>
        <li><a href="{{ route('admin.banners.index') }}">Banners</a></li>
        <li><a href="{{ route('admin.categories.index') }}">Categorías</a></li>
        <li><a href="{{ route('admin.products.index') }}">Productos</a></li>
        <li><a href="{{ route('admin.recipes.index') }}">Recetas</a></li>
        <li><a href="{{ route('admin.contact-messages.index') }}">Mensajes de contacto</a></li>
    </ul>
@endsection

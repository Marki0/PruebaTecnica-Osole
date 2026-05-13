@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
    <h1 style="margin-top:0;">Panel Nikitos</h1>
    <p>Arquitectura base lista. Los módulos CRUD se completarán en siguientes pasos.</p>
    <ul style="line-height:1.8;">
        <li><a href="{{ route('admin.site-sections.index') }}">Textos y secciones</a></li>
        <li><a href="{{ route('admin.banners.index') }}">Banners</a></li>
        <li><a href="{{ route('admin.categories.index') }}">Categorías</a></li>
        <li><a href="{{ route('admin.products.index') }}">Productos</a></li>
        <li><a href="{{ route('admin.recipes.index') }}">Recetas</a></li>
        <li><a href="{{ route('admin.contact-messages.index') }}">Mensajes de contacto</a></li>
    </ul>
    <p><a href="{{ route('home') }}" target="_blank" rel="noopener">Ver sitio público</a></p>
@endsection

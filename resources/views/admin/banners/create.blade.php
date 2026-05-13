@extends('layouts.admin')

@section('title', 'Nuevo banner')

@section('content')
    <h1 style="margin-top:0;">Nuevo banner</h1>
    <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data" class="form-stack">
        @csrf
        @include('admin.banners._form', ['banner' => null])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection

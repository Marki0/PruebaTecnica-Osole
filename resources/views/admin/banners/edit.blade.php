@extends('layouts.admin')

@section('title', 'Editar banner')

@section('content')
    <h1 style="margin-top:0;">Editar banner</h1>
    <form action="{{ route('admin.banners.update', $banner) }}" method="post" enctype="multipart/form-data" class="form-stack">
        @csrf
        @method('PUT')
        @include('admin.banners._form', ['banner' => $banner])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

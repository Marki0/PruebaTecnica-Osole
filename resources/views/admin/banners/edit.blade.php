@extends('layouts.admin')

@section('title', 'Editar hero — '.(\App\Models\Banner::sectionBannersDefinition()[$banner->placement] ?? $banner->placement))

@section('content')
    <h1 style="margin-top:0;">Editar hero — {{ \App\Models\Banner::sectionBannersDefinition()[$banner->placement] ?? $banner->placement }}</h1>
    <form action="{{ route('admin.banners.update', $banner) }}" method="post" enctype="multipart/form-data" class="form-stack">
        @csrf
        @method('PUT')
        @include('admin.banners._form', ['banner' => $banner, 'lockPlacement' => true])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
@endsection

@extends('layouts.admin')

@section('title', $title ?? 'Admin')

@section('content')
    <h1 style="margin-top:0;">{{ $title ?? 'Admin' }}</h1>
    <p>Vista provisional: aquí irá el CRUD o formulario correspondiente.</p>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<h1>Tambah Kategori</h1>
<div class="card">
    <form method="POST" action="{{ route('categories.store') }}">
        @include('categories._form')
    </form>
</div>
@endsection

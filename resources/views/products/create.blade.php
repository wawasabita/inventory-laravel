@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<h1>Tambah Produk</h1>
<div class="card">
    <form method="POST" action="{{ route('products.store') }}">
        @include('products._form')
    </form>
</div>
@endsection

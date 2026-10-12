@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<h1>Edit Produk</h1>
<p>Stok saat ini: <strong>{{ $product->stock }}</strong>. Untuk mengubah stok, gunakan menu Barang Masuk / Barang Keluar.</p>
<div class="card">
    <form method="POST" action="{{ route('products.update', $product) }}">
        @method('PUT')
        @include('products._form')
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Produk')

@section('content')
@php
    $urut = function ($kolom) use ($sort, $dir) {
        $arah = ($sort == $kolom && $dir == 'asc') ? 'desc' : 'asc';
        return route('products.index', array_merge(request()->except(['page', 'sort', 'dir']), ['sort' => $kolom, 'dir' => $arah]));
    };
    $panah = fn ($kolom) => $sort == $kolom ? ($dir == 'asc' ? ' ▲' : ' ▼') : '';
@endphp

<div class="bar">
    <h1>Produk</h1>
    <a href="{{ route('products.create') }}" class="btn">Tambah Produk</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="filter">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU">
    <select name="category_id">
        <option value="">Semua kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn">Cari</button>
    <a href="{{ route('products.index') }}" class="btn btn-abu">Reset</a>
</form>

<table>
    <tr>
        <th><a href="{{ $urut('sku') }}">SKU{{ $panah('sku') }}</a></th>
        <th><a href="{{ $urut('name') }}">Nama{{ $panah('name') }}</a></th>
        <th>Kategori</th>
        <th class="kanan"><a href="{{ $urut('price') }}">Harga{{ $panah('price') }}</a></th>
        <th class="kanan"><a href="{{ $urut('stock') }}">Stok{{ $panah('stock') }}</a></th>
        <th>Aksi</th>
    </tr>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->sku }}</td>
            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
            <td>{{ $product->category->name }}</td>
            <td class="kanan">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td class="kanan {{ $product->stock <= $product->minimum_stock ? 'menipis' : '' }}">{{ $product->stock }}</td>
            <td>
                <div class="aksi">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-abu">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-merah">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="kosong">Belum ada produk.</td></tr>
    @endforelse
</table>

{{ $products->links('paging') }}
@endsection

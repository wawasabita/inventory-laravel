@extends('layouts.app')

@section('title', $type == 'in' ? 'Barang Masuk' : 'Barang Keluar')

@section('content')
<h1>{{ $type == 'in' ? 'Barang Masuk' : 'Barang Keluar' }}</h1>

<div class="card">
    <form method="POST" action="{{ route('stock.store') }}">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <label>Produk</label>
        <select name="product_id">
            <option value="">- pilih produk -</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                    {{ $product->sku }} - {{ $product->name }} (stok {{ $product->stock }})
                </option>
            @endforeach
        </select>
        @error('product_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Jumlah</label>
        <input type="number" name="quantity" value="{{ old('quantity') }}">
        @error('quantity')
            <div class="error">{{ $message }}</div>
        @enderror

        @if($type == 'in')
            <label>Supplier</label>
            <select name="supplier_id">
                <option value="">- tanpa supplier -</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <div class="error">{{ $message }}</div>
            @enderror
        @endif

        <label>Catatan</label>
        <input type="text" name="note" value="{{ old('note') }}">
        @error('note')
            <div class="error">{{ $message }}</div>
        @enderror

        <p>
            <button type="submit" class="btn">Simpan</button>
            <a href="{{ route('stock.index') }}" class="btn btn-abu">Batal</a>
        </p>
    </form>
</div>
@endsection

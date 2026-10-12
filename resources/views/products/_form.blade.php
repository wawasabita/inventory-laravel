@csrf

<label>Kategori</label>
<select name="category_id">
    <option value="">- pilih kategori -</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
    @endforeach
</select>
@error('category_id')
    <div class="error">{{ $message }}</div>
@enderror

<label>SKU</label>
<input type="text" name="sku" value="{{ old('sku', $product->sku) }}">
@error('sku')
    <div class="error">{{ $message }}</div>
@enderror

<label>Nama Produk</label>
<input type="text" name="name" value="{{ old('name', $product->name) }}">
@error('name')
    <div class="error">{{ $message }}</div>
@enderror

<label>Harga</label>
<input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}">
@error('price')
    <div class="error">{{ $message }}</div>
@enderror

@if(!$product->exists)
    <label>Stok Awal</label>
    <input type="number" name="stock" value="{{ old('stock', 0) }}">
    @error('stock')
        <div class="error">{{ $message }}</div>
    @enderror
@endif

<label>Stok Minimum</label>
<input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock ?? 0) }}">
@error('minimum_stock')
    <div class="error">{{ $message }}</div>
@enderror

@php
    $dipilih = old('supplier_ids', $product->exists ? $product->suppliers->pluck('id')->all() : []);
@endphp
<label>Supplier</label>
@foreach($suppliers as $supplier)
    <label class="cek">
        <input type="checkbox" name="supplier_ids[]" value="{{ $supplier->id }}" @checked(in_array($supplier->id, $dipilih))>
        {{ $supplier->name }}
    </label>
@endforeach

<p>
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-abu">Batal</a>
</p>

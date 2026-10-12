@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bar">
    <h1>{{ $product->name }}</h1>
    <a href="{{ route('products.edit', $product) }}" class="btn btn-abu">Edit</a>
</div>

<div class="card">
    <p>SKU: {{ $product->sku }}</p>
    <p>Kategori: {{ $product->category->name }}</p>
    <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p>Stok: <span class="{{ $product->stock <= $product->minimum_stock ? 'menipis' : '' }}">{{ $product->stock }}</span> (minimum {{ $product->minimum_stock }})</p>
    <p>Supplier: {{ $product->suppliers->pluck('name')->join(', ') ?: '-' }}</p>
</div>

<h2>Riwayat Stok Terakhir</h2>
<table>
    <tr>
        <th>Waktu</th>
        <th>Jenis</th>
        <th class="kanan">Jumlah</th>
        <th>Oleh</th>
        <th>Catatan</th>
    </tr>
    @forelse($riwayat as $m)
        <tr>
            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
            <td><span class="badge badge-{{ $m->type }}">{{ $m->type == 'in' ? 'Masuk' : 'Keluar' }}</span></td>
            <td class="kanan">{{ $m->quantity }}</td>
            <td>{{ $m->user->name }}</td>
            <td>{{ $m->note }}</td>
        </tr>
    @empty
        <tr><td colspan="5" class="kosong">Belum ada riwayat.</td></tr>
    @endforelse
</table>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<div class="cards">
    <div class="card">Total Produk<div class="angka">{{ $totalProduk }}</div></div>
    <div class="card">Total Kategori<div class="angka">{{ $totalKategori }}</div></div>
    <div class="card">Total Supplier<div class="angka">{{ $totalSupplier }}</div></div>
    <div class="card">Nilai Stok<div class="angka">Rp {{ number_format($nilaiStok, 0, ',', '.') }}</div></div>
</div>

<h2>Stok Menipis</h2>
<table>
    <tr>
        <th>SKU</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th class="kanan">Stok</th>
        <th class="kanan">Minimum</th>
    </tr>
    @forelse($stokMenipis as $product)
        <tr>
            <td>{{ $product->sku }}</td>
            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
            <td>{{ $product->category->name }}</td>
            <td class="kanan menipis">{{ $product->stock }}</td>
            <td class="kanan">{{ $product->minimum_stock }}</td>
        </tr>
    @empty
        <tr><td colspan="5" class="kosong">Semua stok masih aman.</td></tr>
    @endforelse
</table>

<h2>Transaksi Terakhir</h2>
<table>
    <tr>
        <th>Waktu</th>
        <th>Produk</th>
        <th>Jenis</th>
        <th class="kanan">Jumlah</th>
        <th>Oleh</th>
    </tr>
    @forelse($riwayat as $m)
        <tr>
            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $m->product->name }}</td>
            <td><span class="badge badge-{{ $m->type }}">{{ $m->type == 'in' ? 'Masuk' : 'Keluar' }}</span></td>
            <td class="kanan">{{ $m->quantity }}</td>
            <td>{{ $m->user->name }}</td>
        </tr>
    @empty
        <tr><td colspan="5" class="kosong">Belum ada transaksi.</td></tr>
    @endforelse
</table>
@endsection

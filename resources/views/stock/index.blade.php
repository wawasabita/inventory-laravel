@extends('layouts.app')

@section('title', 'Riwayat Stok')

@section('content')
<div class="bar">
    <h1>Riwayat Stok</h1>
    <div class="aksi">
        <a href="{{ route('stock.create', ['type' => 'in']) }}" class="btn btn-hijau">Barang Masuk</a>
        <a href="{{ route('stock.create', ['type' => 'out']) }}" class="btn btn-merah">Barang Keluar</a>
    </div>
</div>

<form method="GET" action="{{ route('stock.index') }}" class="filter">
    <select name="type">
        <option value="">Semua jenis</option>
        <option value="in" @selected(request('type') == 'in')>Masuk</option>
        <option value="out" @selected(request('type') == 'out')>Keluar</option>
    </select>
    <button type="submit" class="btn">Filter</button>
</form>

<table>
    <tr>
        <th>Waktu</th>
        <th>Produk</th>
        <th>Jenis</th>
        <th class="kanan">Jumlah</th>
        <th>Supplier</th>
        <th>Oleh</th>
        <th>Catatan</th>
    </tr>
    @forelse($movements as $m)
        <tr>
            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $m->product->name }}</td>
            <td><span class="badge badge-{{ $m->type }}">{{ $m->type == 'in' ? 'Masuk' : 'Keluar' }}</span></td>
            <td class="kanan">{{ $m->quantity }}</td>
            <td>{{ $m->supplier->name ?? '-' }}</td>
            <td>{{ $m->user->name }}</td>
            <td>{{ $m->note }}</td>
        </tr>
    @empty
        <tr><td colspan="7" class="kosong">Belum ada transaksi.</td></tr>
    @endforelse
</table>

{{ $movements->links('pagination::default') }}
@endsection

@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="bar">
    <h1>Supplier</h1>
    <a href="{{ route('suppliers.create') }}" class="btn">Tambah Supplier</a>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th class="kanan">Jumlah Produk</th>
        <th>Aksi</th>
    </tr>
    @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->phone }}</td>
            <td>{{ $supplier->address }}</td>
            <td class="kanan">{{ $supplier->products_count }}</td>
            <td>
                <div class="aksi">
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-abu">Edit</a>
                    <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus supplier ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-merah">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="kosong">Belum ada supplier.</td></tr>
    @endforelse
</table>

{{ $suppliers->links('pagination::default') }}
@endsection

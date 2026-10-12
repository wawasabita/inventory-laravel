@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="bar">
    <h1>Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn">Tambah Kategori</a>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th class="kanan">Jumlah Produk</th>
        <th>Aksi</th>
    </tr>
    @forelse($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td class="kanan">{{ $category->products_count }}</td>
            <td>
                <div class="aksi">
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-abu">Edit</a>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-merah">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="kosong">Belum ada kategori.</td></tr>
    @endforelse
</table>

{{ $categories->links('pagination::default') }}
@endsection

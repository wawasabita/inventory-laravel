@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="bar">
    <h1>Pengguna</h1>
    <a href="{{ route('users.create') }}" class="btn">Tambah Pengguna</a>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-merah">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

{{ $users->links('paging') }}
@endsection

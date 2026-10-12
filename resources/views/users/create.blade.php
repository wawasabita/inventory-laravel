@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<h1>Tambah Pengguna</h1>
<div class="card">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Password</label>
        <input type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Ulangi Password</label>
        <input type="password" name="password_confirmation">

        <label>Role</label>
        <select name="role">
            <option value="staff" @selected(old('role') == 'staff')>staff</option>
            <option value="admin" @selected(old('role') == 'admin')>admin</option>
        </select>
        @error('role')
            <div class="error">{{ $message }}</div>
        @enderror

        <p>
            <button type="submit" class="btn">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-abu">Batal</a>
        </p>
    </form>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventory') - Inventory</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="nav">
        <a href="{{ route('dashboard') }}" class="brand">Inventory</a>
        <a href="{{ route('products.index') }}">Produk</a>
        <a href="{{ route('categories.index') }}">Kategori</a>
        <a href="{{ route('suppliers.index') }}">Supplier</a>
        <a href="{{ route('stock.index') }}">Riwayat Stok</a>
        <a href="{{ route('stock.create', ['type' => 'in']) }}">Barang Masuk</a>
        <a href="{{ route('stock.create', ['type' => 'out']) }}">Barang Keluar</a>
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('users.index') }}">Pengguna</a>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <button type="submit" class="btn btn-abu">Keluar</button>
        </form>
    </nav>

    <main class="container">
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        @yield('content')
    </main>
</body>
</html>

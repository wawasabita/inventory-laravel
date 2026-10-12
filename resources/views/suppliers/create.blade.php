@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<h1>Tambah Supplier</h1>
<div class="card">
    <form method="POST" action="{{ route('suppliers.store') }}">
        @include('suppliers._form')
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h1>Edit Supplier</h1>
<div class="card">
    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
        @method('PUT')
        @include('suppliers._form')
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<h1>Edit Kategori</h1>
<div class="card">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @method('PUT')
        @include('categories._form')
    </form>
</div>
@endsection

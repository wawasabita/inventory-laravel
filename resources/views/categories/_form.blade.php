@csrf

<label>Nama Kategori</label>
<input type="text" name="name" value="{{ old('name', $category->name) }}">
@error('name')
    <div class="error">{{ $message }}</div>
@enderror

<label>Deskripsi</label>
<textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>
@error('description')
    <div class="error">{{ $message }}</div>
@enderror

<p>
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-abu">Batal</a>
</p>

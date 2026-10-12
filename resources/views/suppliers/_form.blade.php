@csrf

<label>Nama Supplier</label>
<input type="text" name="name" value="{{ old('name', $supplier->name) }}">
@error('name')
    <div class="error">{{ $message }}</div>
@enderror

<label>Telepon</label>
<input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">
@error('phone')
    <div class="error">{{ $message }}</div>
@enderror

<label>Alamat</label>
<input type="text" name="address" value="{{ old('address', $supplier->address) }}">
@error('address')
    <div class="error">{{ $message }}</div>
@enderror

<p>
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-abu">Batal</a>
</p>

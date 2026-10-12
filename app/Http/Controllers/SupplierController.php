<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private function rules()
    {
        return [
            'name' => ['required', 'max:150'],
            'phone' => ['nullable', 'max:30'],
            'address' => ['nullable', 'max:255'],
        ];
    }

    public function index()
    {
        $suppliers = Supplier::withCount('products')->orderBy('name')->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create', ['supplier' => new Supplier()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil disimpan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate($this->rules());

        $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private function rules($id = null)
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'max:50', Rule::unique('products', 'sku')->ignore($id)],
            'name' => ['required', 'max:150'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'supplier_ids' => ['nullable', 'array'],
            'supplier_ids.*' => ['exists:suppliers,id'],
        ];
    }

    public function index(Request $request)
    {
        $kolomBoleh = ['sku', 'name', 'price', 'stock'];
        $sort = in_array($request->sort, $kolomBoleh) ? $request->sort : 'name';
        $dir = $request->dir == 'desc' ? 'desc' : 'asc';

        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'sort', 'dir'));
    }

    public function create()
    {
        return view('products.create', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules(), [
            'stock' => ['required', 'integer', 'min:0'],
        ]));

        $product = Product::create($request->only(
            'category_id', 'sku', 'name', 'price', 'stock', 'minimum_stock'
        ));
        $product->suppliers()->sync($request->supplier_ids ?? []);

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'suppliers']);
        $riwayat = $product->stockMovements()->with('user')->latest()->take(10)->get();

        return view('products.show', compact('product', 'riwayat'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    // stok tidak diubah di sini, perubahan stok lewat menu Barang Masuk/Keluar
    public function update(Request $request, Product $product)
    {
        $request->validate($this->rules($product->id));

        $product->update($request->only(
            'category_id', 'sku', 'name', 'price', 'minimum_stock'
        ));
        $product->suppliers()->sync($request->supplier_ids ?? []);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->stockMovements()->exists()) {
            return back()->with('error', 'Produk sudah punya riwayat stok, tidak bisa dihapus.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

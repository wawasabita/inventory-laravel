<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product', 'user', 'supplier'])
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('stock.index', compact('movements'));
    }

    public function create(Request $request)
    {
        $type = $request->type == 'out' ? 'out' : 'in';

        return view('stock.create', [
            'type' => $type,
            'products' => Product::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:in,out'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'note' => ['nullable', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            if ($data['type'] == 'out' && $product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak cukup. Stok saat ini: ' . $product->stock,
                ]);
            }

            if ($data['type'] == 'in') {
                $product->stock = $product->stock + $data['quantity'];
            } else {
                $product->stock = $product->stock - $data['quantity'];
            }
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'supplier_id' => $data['type'] == 'in' ? ($data['supplier_id'] ?? null) : null,
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'note' => $data['note'] ?? null,
            ]);
        });

        return redirect()->route('stock.index')->with('success', 'Transaksi stok berhasil disimpan.');
    }
}

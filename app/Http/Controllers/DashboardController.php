<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalSupplier = Supplier::count();
        $nilaiStok = Product::sum(DB::raw('price * stock'));

        $stokMenipis = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        $riwayat = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProduk', 'totalKategori', 'totalSupplier',
            'nilaiStok', 'stokMenipis', 'riwayat'
        ));
    }
}

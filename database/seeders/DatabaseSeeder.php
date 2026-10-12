<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('admin123');
        $admin->role = 'admin';
        $admin->save();

        $staff = new User();
        $staff->name = 'Staff Gudang';
        $staff->email = 'staff@example.com';
        $staff->password = Hash::make('staff123');
        $staff->role = 'staff';
        $staff->save();

        $suppliers = Supplier::factory(5)->create();

        $namaKategori = ['Elektronik', 'Alat Tulis', 'Makanan', 'Minuman', 'Perlengkapan Rumah'];

        foreach ($namaKategori as $nama) {
            $kategori = Category::create(['name' => $nama]);

            Product::factory(8)->create(['category_id' => $kategori->id]);
        }

        foreach (Product::all() as $produk) {
            $produk->suppliers()->attach($suppliers->random(rand(1, 2))->pluck('id'));
        }
    }
}

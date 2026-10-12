# Inventory Management System - Laravel (Pertemuan 5)

Migrasi Inventory Management System P4 (PHP native) ke Laravel.
Business rule tetap sama, yang berubah hanya cara mengorganisasi kodenya.

## 1. Cara Instalasi

Syarat: PHP 8.2 atau lebih baru (cek dengan `php -v`), Composer, XAMPP (MariaDB).

1. Buat project Laravel baru:
   ```
   composer create-project laravel/laravel inventory-laravel
   cd inventory-laravel
   ```
2. Salin semua isi folder ini (`app`, `database`, `public`, `resources`, `routes`) ke dalam folder `inventory-laravel`. Kalau ada pertanyaan replace file, pilih **Replace** (file `routes/web.php` dan `database/seeders/DatabaseSeeder.php` memang diganti).
3. Buat database kosong lewat phpMyAdmin, misalnya `inventory_laravel`.
   Jangan pakai database `inventory_db` milik P4, karena `migrate:fresh` menghapus semua tabel di dalamnya.
4. Buka file `.env`, ubah bagian database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   (Kalau file `.env` belum ada: `cp .env.example .env` lalu `php artisan key:generate`.)
5. Buat tabel dan data uji:
   ```
   php artisan migrate:fresh --seed
   ```
6. Jalankan aplikasi:
   ```
   php artisan serve
   ```
   Buka http://127.0.0.1:8000

Akun bawaan dari seeder:

| Role  | Email             | Password |
|-------|-------------------|----------|
| admin | admin@example.com | admin123 |
| staff | staff@example.com | staff123 |

## 2. Struktur Database (Migration)

| Tabel            | Isi utama |
|------------------|-----------|
| users            | bawaan Laravel + kolom `role` (admin / staff) |
| categories       | name (unik), description |
| suppliers        | name, phone, address |
| products         | category_id, sku (unik), name, price, stock, minimum_stock |
| product_supplier | tabel penghubung many-to-many produk dan supplier |
| stock_movements  | product_id, user_id, supplier_id, type (in/out), quantity, note |

Relationship Eloquent:
- Category `hasMany` Product, Product `belongsTo` Category
- Product `belongsToMany` Supplier, Supplier `belongsToMany` Product
- Product `hasMany` StockMovement, StockMovement `belongsTo` Product, User, Supplier

## 3. Arsitektur MVC

| Bagian     | Tugas | Di project ini |
|------------|-------|----------------|
| Model      | akses data dan relationship | `app/Models/*` |
| View       | tampilan untuk pengguna | `resources/views/*` (Blade) |
| Controller | menerima request, validasi, memanggil model, memilih response | `app/Http/Controllers/*` |

Route (`routes/web.php`) menghubungkan URL ke method controller.

Alur satu request lengkap, contoh tambah produk:

1. Pengguna membuka `/products/create` -> **Route** `GET /products/create`
2. **ProductController@create** menyiapkan data kategori dan supplier, lalu mengembalikan view
3. **View** `products/create.blade.php` menampilkan form (ada `@csrf`)
4. Form dikirim `POST /products` -> **ProductController@store**
5. `validate()` memeriksa input. Kalau salah, kembali ke form dengan pesan error dan data lama (`old()`)
6. Kalau benar, **Model** `Product::create()` menyimpan ke **Database**
7. **Response**: redirect ke `products.index` dengan pesan sukses

## 4. Business Rule yang Dipertahankan dari P4

- Stok produk tidak diubah lewat form edit produk. Perubahan stok hanya lewat Barang Masuk / Barang Keluar.
- Barang keluar ditolak kalau jumlahnya melebihi stok.
- Transaksi stok memakai database transaction dan `lockForUpdate()`, jadi stok dan riwayat tersimpan bersamaan atau batal bersamaan.
- Produk yang sudah punya riwayat stok tidak bisa dihapus.
- Kategori yang masih dipakai produk tidak bisa dihapus.
- Produk dengan stok <= stok minimum tampil di daftar "Stok Menipis" pada dashboard.
- Menu Pengguna hanya bisa dibuka admin (middleware `AdminOnly`).
- Pengguna tidak bisa menghapus akunnya sendiri.

## 5. Pemetaan P4 ke P5

| P4 PHP Native        | P5 Laravel |
|----------------------|------------|
| database/schema.sql  | database/migrations |
| Form PHP manual      | Blade form + validate() |
| Query PDO            | Eloquent |
| File CRUD terpisah   | Resource controller |
| Session manual       | Auth::attempt() dan middleware `auth` |
| include template     | Blade layout (`@extends`) dan component (`<x-alert>`) |

## 6. Daftar File Penting

- `routes/web.php`
- `app/Http/Controllers`: Auth, Dashboard, Category, Supplier, Product, StockMovement, User
- `app/Http/Middleware/AdminOnly.php`
- `app/Models`: Category, Supplier, Product, StockMovement
- `database/migrations`, `database/factories`, `database/seeders/DatabaseSeeder.php`
- `resources/views`: layouts, components, auth, dashboard, categories, suppliers, products, stock, users

## 7. Screenshot untuk Dikumpulkan

Ambil screenshot berikut dan tempel di sini atau di dokumen terpisah:
- [ ] hasil `php artisan route:list`
- [ ] halaman login dan dashboard
- [ ] daftar produk (dengan search, filter, sorting, pagination)
- [ ] form tambah produk dengan pesan error validasi
- [ ] form barang keluar yang ditolak karena stok tidak cukup
- [ ] riwayat stok

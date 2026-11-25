# Menjalankan Laundry Desk

Project sudah memiliki kerangka yang dapat dijalankan setelah alat berikut tersedia di komputer:

1. Node.js 20 LTS dan npm.
2. PHP 8.2 atau lebih baru dan Composer.
3. PostgreSQL 15 atau lebih baru.
4. Rust stable dan WebView2 Runtime untuk membuat aplikasi desktop Tauri.

Sesudah Node.js tersedia, dari folder project jalankan:

```powershell
npm install
npm run dev:desktop
```

Untuk melihat web pelanggan:

```powershell
npm run dev:web
```

Login desktop menggunakan data demo yang langsung terisi. Peran dapat dipilih melalui kotak `Masuk sebagai`. Web pelanggan mempunyai tombol masuk demo tersendiri.

Backend memakai Laravel 12 di `backend/laravel` dan PostgreSQL. Setelah mengatur `.env` dengan kredensial PostgreSQL, jalankan:

```powershell
cd backend/laravel
php artisan serve
```

Login demo front-end akan diganti dengan Laravel Sanctum dan data PostgreSQL pada tahap autentikasi.

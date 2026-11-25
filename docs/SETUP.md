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

Backend Laravel dan PostgreSQL belum dibuat karena PHP serta Composer belum tersedia pada mesin ini. Tahap berikutnya akan mengganti data demo dan sesi `localStorage` dengan Laravel Sanctum.

# Status Implementasi Laundry Desk

## Keputusan tahap awal

- Produk memakai nama **Laundry Desk** dan logo yang diberikan pengguna.
- Desktop dipakai oleh Platform Admin dan Admin Toko; pelanggan memakai web responsif.
- Tema implementasi awal memakai biru tua, biru muda, putih, dan abu-abu netral. Hijau dipertahankan hanya untuk status berhasil atau aksi yang bernilai positif.
- Ilustrasi laundry akan dipasang setelah aset final siap. Struktur halaman sudah disiapkan agar ilustrasi dapat masuk tanpa mengubah alur aplikasi.

## Kondisi lingkungan pada 25 November 2026

- Folder awal hanya memiliki dokumen dan aset desain, belum memiliki source code.
- Git tersedia pada branch `main`.
- PostgreSQL 18 tersedia dan menerima koneksi lokal. PHP 8.2 dari XAMPP sudah diaktifkan untuk `pgsql`, `pdo_pgsql`, dan `zip`. Node portable tersedia di `.tools/node` untuk membangun front-end.

## Tahap 1-3

1. Fondasi arsitektur monorepo dan konfigurasi workspace: selesai.
2. Kerangka React untuk Desktop dan Web, serta pustaka UI bersama: selesai.
3. Login demo, penyimpanan sesi lokal, role guard, dan tujuan per peran: selesai untuk front-end.
4. Dashboard admin, daftar pesanan, dan alur pesanan tiga langkah: selesai sebagai data demo.
5. Web pelanggan dengan pemilihan outlet dan alur pesanan: selesai sebagai data demo.
6. Backend Laravel 12: kerangka dan dependensi inti tersedia di `backend/laravel`.
7. Sanctum, migration inti, seeder, middleware role, dan 19 rute API tersedia. Menunggu kredensial PostgreSQL agar migration dan seeder dapat dijalankan di database lokal.
8. PostgreSQL sudah tersambung; seluruh migration dan seeder berjalan. Login admin serta pelanggan, pembuatan pesanan, perubahan status, dan pembatasan role sudah diuji melalui API.

## Berikutnya

- Ganti data demo dan sesi `localStorage` dengan Laravel Sanctum.
- Buat migration PostgreSQL, endpoint API, policy, dan seeder.
- Hubungkan Desktop serta Web ke API melalui TanStack Query.

# Setup PostgreSQL Laundry Desk

Laravel membutuhkan PostgreSQL lokal yang sudah berjalan.

## 1. Buat database

Buka SQL Shell PostgreSQL, masuk dengan akun `postgres`, lalu jalankan:

```sql
CREATE DATABASE laundry_desk;
```

## 2. Atur environment Laravel

Salin `backend/laravel/.env.example` menjadi `backend/laravel/.env` bila belum ada. Isi bagian berikut memakai password PostgreSQL yang kamu buat saat instalasi:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laundry_desk
DB_USERNAME=postgres
DB_PASSWORD=password_postgresql_kamu
```

Password tidak ditulis di dokumentasi, source code, atau Git.

## 3. Bangun data aplikasi

Dari folder `backend/laravel`, jalankan:

```powershell
php artisan migrate:fresh --seed
php artisan serve
```

Perintah pertama membuat seluruh tabel dan akun demo. Perintah kedua menjalankan API pada `http://127.0.0.1:8000`.

## 4. Periksa API

Buka `http://127.0.0.1:8000/up`. Untuk rute aplikasi, lihat [API.md](../backend/laravel/API.md).

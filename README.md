# Laundry Desk

Laundry Desk adalah aplikasi manajemen laundry dengan dua antarmuka:

- Desktop untuk Platform Admin dan Admin Toko.
- Web responsif untuk pelanggan.

## Teknologi

| Bagian | Teknologi |
|---|---|
| Frontend | React 18, TypeScript, Vite |
| Desktop | Tauri 2 |
| Backend | PHP 8.2, Laravel 12, Sanctum |
| Database | PostgreSQL |

## Struktur

```text
frontend/desktop     aplikasi admin
frontend/web         aplikasi pelanggan
frontend/shared-ui   tipe dan utilitas bersama
backend/laravel      API Laravel 12
docs/                status dan petunjuk setup
```

## Menjalankan frontend

Node portable telah dipakai selama pengembangan, tetapi untuk penggunaan harian pasang Node.js LTS agar `node` dan `npm` tersedia dari terminal.

```powershell
npm install
npm run dev:desktop
npm run dev:web
```

## Menjalankan backend

1. Salin `backend/laravel/.env.example` menjadi `.env`.
2. Isi `DB_PASSWORD` dengan password PostgreSQL lokal. Jangan masukkan password ke Git.
3. Buat database `laundry_desk` pada PostgreSQL.
4. Jalankan perintah berikut dari `backend/laravel`:

```powershell
php artisan migrate:fresh --seed
php artisan serve
```

API tersedia pada `http://127.0.0.1:8000/api`.

## Akun demo

Password semua akun: `Laundry123!`

| Peran | Email |
|---|---|
| Platform Admin | admin@laundrydesk.test |
| Admin Toko | toko@laundrydesk.test |
| Pelanggan | pelanggan@laundrydesk.test |

Dokumen endpoint API ada di [backend/laravel/API.md](backend/laravel/API.md). Daftar kerja demo final ada di [TASKS_DEMO_FINAL.md](TASKS_DEMO_FINAL.md).

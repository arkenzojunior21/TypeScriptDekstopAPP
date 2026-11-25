# Laundry Desk API

Semua endpoint berada di bawah `/api`. Endpoint yang diberi tanda token membutuhkan header berikut:

```text
Authorization: Bearer TOKEN_SANCTUM
Accept: application/json
```

## Autentikasi

| Method | Endpoint | Fungsi |
|---|---|---|
| POST | `/auth/register` | Daftar pelanggan. Kirim `name`, `email`, `phone`, `password`, `password_confirmation`. |
| POST | `/auth/login` | Login semua role. Kirim `email`, `password`, opsional `device_name`. |
| GET | `/auth/me` | Profil sesi aktif. Token. |
| POST | `/auth/logout` | Mencabut token aktif. Token. |

## Operasional

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/stores` | Daftar outlet aktif. |
| GET | `/stores/{id}` | Detail outlet dan layanan aktif. |
| GET | `/services?store_id={id}` | Layanan aktif per toko. |
| GET | `/orders` | Pesanan menurut role. Token. |
| POST | `/orders` | Buat pesanan. Token. |
| PATCH | `/orders/{id}/status` | Ubah status oleh admin. Token. |
| GET | `/customers` | Daftar pelanggan bagi admin. Token. |
| GET/POST | `/complaints` | Lihat atau buat komplain. Token. |
| GET | `/reports/summary` | Metrik dashboard. Token admin. |

## Akun demo setelah seeder dijalankan

Semua password: `Laundry123!`

| Role | Email |
|---|---|
| Platform Admin | `admin@laundrydesk.test` |
| Admin Toko | `toko@laundrydesk.test` |
| Pelanggan | `pelanggan@laundrydesk.test` |

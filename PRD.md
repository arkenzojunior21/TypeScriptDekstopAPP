# Product Requirements Document (PRD.md) — TypeScript Desktop App

## 1. Project Vision
Build a modern **laundry marketplace** desktop application using **TypeScript + React + Tauri 2**. The app serves 3 roles:
- **Platform Admin** — system-wide management via desktop
- **Store Admin** — store operations via desktop
- **Customer** — order via web PWA (browser)

Backend: Laravel API + PostgreSQL. UI: TypeScript + React + Tailwind CSS + shadcn/ui with primary color **#10B981** (hijau).

## 2. Target Users
| Role | Platform | Primary Tasks |
|------|----------|---------------|
| **Platform Admin** | Desktop app | System-wide user management, settings, global reports, audit log, manage Admins |
| **Store Admin** | Desktop app | Manage own store: services & rates, orders, customers, complaints, pickup/delivery schedule, local reports |
| **Customer** | Web browser | Register/Login, browse services, place order (3-step), track status, view history, make payment |

## 3. Scope
### In-Scope
- **Backend**: Laravel API, Sanctum auth, PostgreSQL, resource controllers, policies
- **Frontend (Shared)**: TypeScript + React 18 + Vite + Tailwind 3.3 + shadcn/ui v0.6 + Zustand + TanStack Query + React Router 6
- **Desktop**: Tauri 2 wraps React app; native features: custom titlebar, system tray, filesystem export, OS notifications
- **Web**: PWA manifest, service worker for caching, responsive breakpoints
- **3 Role Flow**: Login → role-based routing → platform-specific UI
- **Shared UI Library**: Reusable components in `shared-ui` (Button, Input, Card, Table, Badge, Dialog, Toast, Progress, Chart wrapper)
- **3-Step Order Flow**: Pelanggan → Layanan & Berat/Qty → Ringkasan & Pembayaran
- **Core Screens**: Login, Register, Dashboard (both Admins), Order List, Create Order, Pelanggan Management, Layanan & Tarif, Komplain, Laporan, Profil User

### Out-of-Scope (Future)
- Accounting integration
- Multi-currency
- Advanced analytics (AI predictions)
- Mobile native apps (iOS/Android)
- ERP integration

## 4. Functional Requirements

### 4.1 Authentication & Authorization
- **Login page**: email/username + password; remember me option
- **Register page**: nama lengkap, email, password, konfirmasi password, telepon opsional
- **Role-based access**: after login, redirect:
  - Platform Admin → Desktop dashboard (system-wide)
  - Store Admin → Desktop dashboard (own store only)
  - Customer → Web order dashboard
- **Guards**: Laravel `role` middleware + React route guards
- **Password policy**: minimum 8 characters, mix alpha-numeric, expire after 90 days (Phase 2)

### 4.2 Dashboard (Desktop — both Admin Roles)
- **Top Bar**: page title left, connection indicator (Online/OFFLINE hijau/merah), bell notifikasi badge, branch selector (Kemang, Jakarta)
- **Key Metrics Row** (2 rows = 6 cards):
  - Row 1: Pesanan hari ini (48, +12% hijau), Pendapatan hari ini (Rp 4,86jt, -8.4% merah), Pesanan baru (12, Perlu diproses orange)
  - Row 2: Sedang dicuci (9), Siap diambil (7), Dalam perjalanan (4)
- **Progress bar**: Target bulanan Rp 86.4jt dari Rp 120jt (72% hijau)
- **Weekly chart**: LineSeries area hijau #34D399, x-axis Sen-Sab (Indonesia), tooltip 84 di Kam, filter 7 hari / 30 hari / Semua
- **Recent Activity**: 5 item list — action, user/customer, waktu relatif (2 menit lalu / 8 menit lalu), dot status hijau/biru/orange
- **Sidebar**: fixed 240px, grouped OPERASIONAL (Beranda*, Buat Pesanan, Daftar Pesanan, Pelanggan, Jadwal Antar-Jemput) + MANAJEMEN (Layanan & Tarif, Komplain, Laporan, Riwayat Audit). Active item hijau #10B981 highlight.
- **FAB bottom-right**: hitam dengan tanda tanya putih (bantuan/bantuan online)

### 4.3 Order Flow (Create Order — 3 Steps)
- **Progress indicator**: 3 kotak lingkaran berurutan, kotak aktif hijau #10B981, garis hijau 2px
- **Step 1: Pilih Pelanggan**
  - Search bar placeholder "Cari pelanggan berdasarkan nama/telepon..."
  - Grid card pelanggan: avatar circular, nama, total pesan sebelumnya, tombol "Pilih" hijau #10B981
  - Jika kosong: teks "Tidak ada pelanggan terdaftar"
- **Step 2: Layanan & Berat/Qty**
  - Tabel daftar layanan: Nama Layanan, Deskripsi, Harga, Satuan (kg/unit), Aksi (+) tambah baris
  - Setiap baris input qty (input number border hijau focus), subtotal otomatis muncul di samping
  - Total keseluruhan di bawah tabel warna hijau #10B981 teks bold
  - Radio button metode pembayaran (Cash, Transfer, Dana/Gopay) — aktif hijau #10B981
- **Step 3: Ringkasan & Pembayaran**
  - Card ringkasan: pelanggan terpilih, daftar layanan dengan qty & subtotal, total harga besar hijau #10B981 pojok kanan
  - Konfirmasi pesan: "Anda yakin ingin memesan?" dengan 2 button: Batal (abu-abu) & Konfirmasi Pesanan (hijau #10B981 lebar penuh height 56px)
- **Navigation**: Tombol "BACK" kiri atas (abu-abu) & "NEXT" kanan atas (hijau) antar step. Step 3 hanya ada tombol "Konfirmasi Pesanan".

### 4.4 Order List (Desktop & Web)
- **Header tools**: Filter dropdown status (Semua, Baru, Proses, Selesai, Dibatalkan), Tgl Range picker, Export CSV button
- **Tabel daftar pesanan**: kolom #, Tanggal Pesan, Pelanggan, Layanan, Berat, Total Harga, Status badge, Aksi
- **Baris tabel**: zebra striping, hover row warna #F1F5F9, sticky header
- **Paginasi**: tombol Previous 1 2 3 Next abu-abu, 4 per page default
- **Empty state**: "Belum ada pesanan, mulai dengan menambahkan layanan dan pelanggan"

### 4.5 Pelanggan Management
- **Grid card daftar pelanggan**: 3 card per row desktop, avatar circular initials, nama bold, total pesan & total belanja di bawah, tombol "Lihat Riwayat" hijau #10B981 kanan bawah
- **Floating button hijau #10B981 kanan bawah**: "Tambah Pelanggan Baru"
- **Detail pelanggan**: info diri (email, telepon, alamat), tabel riwayat pesan ini (filter tgl), tombol "Edit Profil" & "Hapus Pelanggan" (konfirmasi alert)
- **Search bar**: atas kanan placeholder "Cari pelanggan..."

### 4.6 Layanan & Tarif
- **Tombol tambah layanan hijau #10B981 kanan atas baru**
- **Form input**: Nama layanan input, Deskripsi textarea, Harga input Rupiah, Satuan dropdown (Kg/Unit), Toggle Status Aktif/Matikan
- **Tabel daftar layanan**: Kolom Nama Layanan, Deskripsi singkat, Harga, Satuan, Status toggle (warna hijau saat aktif), Aksi (icon edit, icon hapus)
- **Subtabel harga per jenis**: jika ada Cetak Kilat, Reguler, Express per baris layanan
- **Empty state**: "Belum ada layanan, tambah layanan pertama"

### 4.7 Komplain
- **Filter status**: Semua, Baru, Diproses, Selesai di atas tabel
- **Tabel daftar keluhan**: Nomor Keluhan, Nama Pelanggan, Pesanan Terkait, Keluhan (ringkasan 1 baris), Status badge, Tanggal Dibuat, Aksi
- **Aksi per row**:
  - Ubah status dropdown (Baru/Diproses/Selesai)
  - Tombol "Balas Komplain" (buka modal teks)
  - Tombol "Tutup Keluhan"
- **Modal balasan komplain**: textarea pesan, tombol "Kirim Balasan" hijau #10B981, tombol Batal abu-abu
- **Empty state**: "Tidak ada keluhan masukan dari pelanggan"

### 4.8 Laporan
- **Filter periode**: Hari ini, Minggu ini, Bulan ini, Kustom range (calendar picker) di kanan atas
- **Tabel ringkasan statistik** di atas garis pemisah:
  - Total Pelanggan Aktif | Total Pesanan (hari ini/minggu ini) | Total Pendapatan Rupiah | Pelanggan Paling Sering | Layanan Paling Laris
- **Grafik** di bawah statistik: line chart jumlah pesanan per minggu area hijau #34D399, filter tgl custom range
- **Export CSV/Excel**: butoon kanan atas samping filter
- **Empty state**: "Tidak ada data untuk periode dipilih"

### 4.9 Riwayat Audit
- **Filter**: Tgl Range, User/Role, Aksi di atas tabel
- **Tabel log aktivitas**: kolom Waktu (format "1 menit lalu"/"2 hari lalu"), User & Role, Aksi Deskripsi (contoh: "Nadia Amalia - Store Admin - Menambah layanan Cetak Kilat"), Target
- **Paginasi** di bawah tabel
- **Empty state**: "Catatan aktivitas masih kosong"

### 4.10 Profil User
- **Section info diri** kiri atas: foto circular avatar besar, nama di bawah, email, nomor telepon, role badges (Store Admin warna hijau #10B981)
- **Form ubah password** di bawah info diri: input kata sandi lama, input kata sandi baru, konfirmasi kata sandi baru
- **Setting notifikasi** di bawah password: checkbox Email, SMS, In-app Notification (warna abu-abu)
- **Tombol Keluar Login** kanan bawah warna merah #EF4444 dengan ikon logout

## 5. Non-Functional Requirements

### 5.1 Performance
- Page load < 2s (web) on 3G simulation
- Dashboard metrics fetch via TanStack Query stale-while-revalidate
- Charts render < 500ms with 50 data points
- Table virtualization for > 100 rows

### 5.2 Responsiveness
- **Desktop**: 1440px wide, sidebar always visible
- **Web**: mobile-first breakpoints (sm: 640px, md: 768px, lg: 1024px, xl: 1280px)
- **Table**: horizontal scroll on mobile, card grid converts to 1 column

### 5.3 Accessibility
- Contrast minimum 4.5:1 (hijau #10B981 pada putih ✓)
- Focus visible state pada semua interaktif elemen (border 2px solid #10B981)
- Semua teks Bahasa Indonesia
- Screen reader labels pada icon, tombol, form

### 5.4 Security
- Laravel Sanctum token di header Authorization: "Bearer {token}"
- CSRF protection on all POST/PUT/DELETE routes
- Role middleware on every endpoint — never skip
- No password di client-side code
- Input sanitization via Laravel validation rules

### 5.5 Maintainability
- Shared UI components in `shared-ui` — never duplicate between web/desktop
- Tailwind config satu-satunya (tidak ada custom CSS files)
- TypeScript types untuk semua props komponen & API responses
- Conventional commit messages
- Vitest unit tests untuk components & utilities
- Playwright e2e untuk alur login + order flow

## 6. UI/UX Design Specifications (Enforced)

### 6.1 Color System
```css
:root {
  --primary: #10B981;      /* hijau utama — button aktif, metrik positif, progress */
  --primary-hover: #059669; /* satu tone lebih gelap */
  --secondary: #0F172A;    /* sidebar & teks utama */
  --background: #F8FAFC;   /* light mode background */
  --card: #FFFFFF;         /* card & modal */
  --warning: #F59E0B;      /* orange — pending/in-progress */
  --danger: #EF4444;       /* red — error/destructive */
  --muted: #64748B;        /* secondary text */
  --success: #10B981;      /* alias untuk hijau */
}
```

### 6.2 Typography
```css
font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
font-size: 12px (xs) 14px (sm) 16px (md) 18px (lg) 20px (xl);
font-weight: normal (400) / medium (500) / bold (700);
letter-spacing: normal;
line-height: 1.5;
```

### 6.3 Spacing & Radius
- Scale: 4px (0, 4, 8, 12, 16, 24, 32, 40, 48, 64)
- Border radius: 4px (input, small elements), 8px (card, button, modal), 12px (avatar large)
- Padding: komponen menggunakan scale 4px

### 6.4 Component Specifications
- **Button**: variant default (hijau #10B981 teks putih), destructive (merah), outline (abu-abi dengan hijau border), ghost (transparan hijau hover). Height 40px minimum, radius 8px, focus ring 2px solid #10B981.
- **Input**: bordered warna #CBD5E1, focus ring hijau #10B98I lebar 2px, padding 8px 12px, radius 4px, placeholder abu-abu #9CA3AF.
- **Badge**: pill shape radius 9999px, height 24px, font 10px uppercase. Hijau untuk success, oranye untuk warning, merah untuk danger, biru untuk info.
- **Card**: shadow 0 1px 2px rgba(0,0,0,0.05), radius 8px, padding 16px, background putih.
- **Table**: zebra striping warna #F1F5F9 baris ganjil, hover row #E2E8F, sticky header, radius 8px.
- **Progress bar**: height 8px, background #E2E8F, progress hijau #10B98I. Tidak ada border radius (full width).
- **Dialog/Modal**: radius 8px, shadow 0 4px 20px rgba(0,0,0,0.1), padding 24px, tombol OK di bawah warna hijau #10B981 lebar penuh.

### 6.5 Layout Rules
- **Sidebar**: 240px fixed width, height 100vh, background #0F172A, padding vertical 24px. Item aktif warna hijau #10B98I background, teks putih. Item non-aktif warna #334155. Divider abu-abi sangat terang antar group: OPERASIONAL & MANAJEMEN.
- **Top Bar**: height 56px, background putih, shadow 0 1px 0 rgba(0,0,0,0.05). Kiri: page title + ikon home. Kanan: Online indicator hijau 16x16 + bell badge merah jika ada + branch selector dropdown 140px width.
- **Progress Indicator (3-step)**: height 40px, 3 kotak lingkaran diameter 40px, jarak antar kotak 8px. Garis menghubungkannya 2px height. Aktif warna hijau #10B98I, belum aktif abu-abi #9CA3AF. Teks di dalam kotak: "1. Pelanggan", "2. Layanan & Berat", "3. Ringkasan & Pembayaran".
- **Top Grid (Metrics)**: 2 row x 3 column, card height 140px, width 100%. Jarak antar card 16px horizontal & vertikal.
- **Bottom Grid (Status)**: 3 card horizontal di bawah metrics, height 80px each, width 33.33% each, jarak antar card 8px.

### 6.6 Animation & Interactions
- **Button hover**: background warna tone lebih gelap, transform translate-y-[2px]
- **Input focus**: border warna hijau #10B98I muncul 200ms ease, shadow 0 0 0 3px rgba(16,185,129,0.1)
- **Chart tooltip**: fade-in 150ms, crosshair vertical/horizontal
- **Progress bar animate**: width dari 0% ke target persentase selama 2s saat data berubah
- **Toast notification**: muncul dari kanan bawah, auto-dismiss 5 detik, slide-in 200ms
- **Tab view switch**: fade 300ms between tabs

## 7. Data Model Summary (PostgreSQL)

### 7.1 Tables (core)
- `users` — id, name, email, password, role (enum: platform_admin, store_admin, customer), store_id (nullable), phone, avatar_url, last_login_at, remember_token, created_at, updated_at
- `stores` — id, name, address, phone, latitude, longitude, owner_id (users), status (aktif/matikan), created_at, updated_at
- `services` — id, name, description, price_per_satuan, satuan (enum: kg/unit), status (aktif/matikan), store_id, created_at, updated_at
- `orders` — id, user_id, store_id, customer_name, customer_phone, customer_address, service_id, berat_kg, qty, total_harga, status (enum: baru/proses/selesai/dibatalkan), payment_method (enum: cash/transfer/dana), payment_status (enum: unpaid/paid/refunded), notes, created_at, updated_at
- `complaints` — id, order_id, user_id, store_id, customer_name, customer_phone, complaint_text, status (enum: baru/diproses/selesai), admin_response_text, resolved_at, created_at, updated_at
- `audit_logs` — id, user_id (nullable), action (enum), target_type (enum), target_id (integer), details (jsonb), ip_address, user_agent, created_at

### 7.2 Relationships
- User ↔ Store (one store for store_admin, nullable for platform_admin)
- Store ↔ Services (one-to-many)
- Store ↔ Orders (one-to-many)
- User ↔ Orders (many-to-many via pivot or user owns orders as customer)
- Order ↔ Services (many-to-one)
- Order ↔ Complaints (one-to-one or one-to-many)
- Audit logs ↔ User (who performed action)

## 8. API Endpoints (Laravel Sanctum Protected)

### Auth
- `POST /api/login` → token
- `POST /api/register` → token
- `POST /api/logout` → revoke token
- `GET /api/user` → user profile + role

### Users (guarded by role middleware)
- `GET /api/users` → index (platform/admin only)
- `GET /api/users/{id}` → show
- `POST /api/users` → store (platform/admin)
- `PUT /api/users/{id}` → update
- `DELETE /api/users/{id}` → destroy

### Stores
- `GET /api/stores` → index
- `GET /api/stores/{id}` → show
- `PUT /api/stores/{id}` → update status

### Services
- `GET /api/services` → index (filter by store_id)
- `POST /api/services` → store admin create
- `PUT /api/services/{id}` → update
- `DELETE /api/services/{id}` → destroy

### Orders
- `GET /api/orders` → index (filter status, tgl range, store_id)
- `POST /api/orders` → store admin/create customer order
- `GET /api/orders/{id}` → show
- `PUT /api/orders/{id}` → update status (admin only)
- `PUT /api/orders/{id}/payment` → update payment status

### Complaints
- `GET /api/complaints` → index (filter status)
- `POST /api/complaints` → customer submit
- `PUT /api/complaints/{id}` → admin update status + response
- `DELETE /api/complaints/{id}` → admin soft delete (optional)

### Reports
- `GET /api/reports` → summary stats + chart data (filter periode)
- `GET /api/reports/export` → CSV/Excel file

### Audit
- `GET /api/audit-logs` → index (filter tgl, user, action)

## 9. Deployment Configuration

### 9.1 Backend (Laravel)
- PHP 8.2+ with extensions: pdo_pgsql, mbstring, xml, tokenizer, bcmath
- Queue: synchronous for MVP (Phase 2: Redis + Laravel Horizon)
- Cache: file or Redis
- Session: database-backed
- Logging: single channel daily
- Environment: `.env` with database config, JWT settings

### 9.2 Frontend (Web)
- Node 20+, npm/yarn/pnpm
- Hosting: Render/Vercel (frontend) + Railway/Render (backend API)
- Domain: custom domain optional, HTTPS via Let's Encrypt
- PWA: manifest.json + service worker for offline caching core assets

### 9.3 Desktop (Tauri)
- Rust 1.70+ + Tauri 2.0+
- Windows: WebView2 runtime installed (auto-prompt user at first launch)
- Config: `tauri.conf.json` with `tauri.window` -> `decorations: false`, `title bar -> hidden`, `theme -> dark` (but default light mode), `system-tray -> true`
- Build: `cargo tauri build` generates `.msi` installer

### 9.4 Database (PostgreSQL)
- Local dev: PostgreSQL 15+ (port 5433 default)
- Production: separate instance (Render, Neon, or VPS)
- ORM: Laravel Eloquent + migrations seeded
- No SQLite — enforced in stack

## 10. Phase Roadmap

### Phase 1 — MVP (6-8 weeks)
- Auth (login/register, role redirect)
- Shared UI library (all core components)
- Dashboard desktop (metrics, chart, sidebar, top bar)
- Order flow web (3-step create order + order list)
- Admin panels: services, pelanggan, komplain, laporan
- PostgreSQL schema + seeders
- Basic RBAC on all endpoints

### Phase 2 — Enhancements (4-6 weeks)
- Real-time order status push via Laravel Reverb/WebSocket
- Multi-branch support (store_id filtering)
- Export laporan CSV/Excel with formatting
- Advanced charts: comparison, targets vs actual
- Tauri updater auto
- Dark mode optional toggle

### Phase 3 — Scale (8-12 weeks)
- Multi-tenant (several cities/countries)
- Mobile native apps (React Native + Expo)
- AI-powered demand forecasting
- Integration with payment gateways (Midtrans, Xendit)
- Advanced analytics dashboard

## 11. Acceptance Criteria (Definition of Done)
✅ Login/register flow works on both web & desktop  
✅ Role-based routing sends user to correct platform  
✅ Dashboard metrics display correctly with live API data  
✅ Weekly chart shows with tooltip & filter  
✅ 3-step create order completes successfully end-to-end  
✅ Order list shows filtered data with pagination  
✅ All forms validate (client + server) with proper error messages  
✅ Sidebar groups OPERASIONAL + MANAJEMEN with correct items  
✅ Top bar shows connection status + bell badge + branch  
✅ Progress bar reflects target percentage correctly  
✅ Badge colors match: hijau success, oranye warning, merah danger, biru info  
✅ Toast notifications appear for actions (order created, complaint submitted)  
✅ Export CSV works from reports page  
✅ Password reset flow (Phase 2)  
✅ No crashes on edge cases (empty state, null values)  
✅ Code follows TypeScript strict mode + ESLint + Prettier  
✅ All new components added to `shared-ui` library  
✅ PostgreSQL schema migration runs without errors  
✅ Documentation updated (README + agent.md + this PRD)

## 12. Quick Reference Commands
```bash
# Backend
cd backend && composer install && php artisan migrate --seed

# Shared UI
cd frontend/shared-ui && npm install && npm run lint && npm run test

# Web
cd frontend/web && npm install && npm run dev      # starts Vite dev server

# Desktop
cd frontend/desktop && npm install && npm run tauri dev  # starts Tauri with React

# Tests
cd .. && vendor/bin/pest   # PHP tests
cd frontend && npm test   # Vitest/Playwright

# Build
vendor/bin/php artisan optimize   # clear config/cache
npm run build   # Vite build for production
cargo tauri build   # Tauri Windows installer
```

---
*PRD.md — Single source of truth for TypeScript Desktop App laundry marketplace. 
All development must follow stack, architecture, and design specifications herein.*
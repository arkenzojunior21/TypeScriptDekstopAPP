# Laundry Desk — Checklist menuju Demo Final

Tujuan dokumen ini adalah membawa Laundry Desk dari prototype UI menjadi aplikasi desktop admin dan web pelanggan yang dapat dipresentasikan tanpa memakai data palsu di layar utama.

## Status saat ini

- [x] Dokumen kebutuhan dan desain dibaca.
- [x] Workspace React untuk desktop dan web dibuat.
- [x] Kerangka Tauri dibuat.
- [x] Laravel 12 terpasang.
- [x] PHP 8.2 telah aktif dengan driver PostgreSQL.
- [x] PostgreSQL lokal tersedia.
- [x] Frontend desktop dan web berhasil production build.
- [x] Login dan role demo tersedia menggunakan `localStorage`.
- [x] Dashboard, daftar pesanan, dan form pesanan demo tersedia.
- [ ] Data demo diganti menjadi data dari API dan PostgreSQL.

---

## Tahap 4 — Persiapan backend dan database

Tujuan: Laravel dapat terhubung ke PostgreSQL dan memiliki struktur data yang benar.

- [ ] Buat database PostgreSQL `laundry_desk`.
- [ ] Atur `.env` Laravel untuk PostgreSQL lokal.
- [ ] Pastikan tidak ada konfigurasi SQLite.
- [ ] Tambahkan Laravel Sanctum.
- [ ] Buat migration untuk `users` dengan role, nomor telepon, `store_id`, avatar, dan waktu login terakhir.
- [ ] Buat migration `stores` dengan nama, alamat, telepon, latitude, longitude, pemilik, dan status.
- [ ] Buat migration `services` dengan layanan, harga, satuan, status, dan toko.
- [ ] Buat migration `customers` bila pelanggan dipisahkan dari tabel pengguna, atau tetapkan relasi pelanggan pada tabel pengguna.
- [ ] Buat migration `orders` dengan pelanggan, toko, status, berat/kuantitas, total, metode dan status pembayaran, catatan, serta waktu pesanan.
- [ ] Buat migration detail layanan pesanan agar satu pesanan dapat memiliki lebih dari satu layanan.
- [ ] Buat migration `complaints`.
- [ ] Buat migration `audit_logs`.
- [ ] Tambahkan index untuk kolom pencarian dan filter: email, role, store, status, tanggal pesanan.
- [ ] Jalankan migration dari database kosong.
- [ ] Buat seeder data awal dan uji ulang dengan `migrate:fresh --seed`.

Hasil tahap: database dapat dibuat ulang dari nol dengan satu perintah.

---

## Tahap 5 — Login, akun, dan hak akses

Tujuan: setiap peran memakai akun serta akses yang benar.

- [ ] Buat endpoint register pelanggan.
- [ ] Buat endpoint login dengan Laravel Sanctum.
- [ ] Buat endpoint logout yang mencabut token.
- [ ] Buat endpoint profil pengguna aktif.
- [ ] Buat validasi email, password, telepon, dan data profil.
- [ ] Buat middleware role: Platform Admin, Admin Toko, Pelanggan.
- [ ] Buat policy agar Admin Toko hanya melihat data tokonya sendiri.
- [ ] Buat policy agar pelanggan hanya melihat pesanan dan komplain miliknya sendiri.
- [ ] Buat redirect role pada frontend setelah login API berhasil.
- [ ] Simpan token dengan aman: browser memakai penyimpanan lokal sementara, desktop memakai penyimpanan aman Tauri saat integrasi Tauri selesai.
- [ ] Ganti akun demo frontend menjadi akun API.
- [ ] Uji akun tanpa role yang tepat tidak dapat membuka rute atau API terlarang.

Hasil tahap: login dan pembatasan akses bekerja untuk tiga peran.

---

## Tahap 6 — API dan operasional inti admin

Tujuan: Admin Toko dapat menjalankan pesanan dengan data nyata.

### Toko dan lokasi

- [ ] API daftar toko.
- [ ] API detail toko.
- [ ] API ubah pengaturan toko milik Admin Toko.
- [ ] API Platform Admin untuk membuat, mengubah, dan menonaktifkan toko.
- [ ] Simpan latitude dan longitude toko.

### Layanan dan tarif

- [ ] API daftar layanan per toko.
- [ ] API tambah layanan.
- [ ] API ubah layanan.
- [ ] API aktif/nonaktif layanan.
- [ ] API hapus layanan dengan konfirmasi aman.
- [ ] Validasi harga, satuan kilogram/unit, dan status.

### Pelanggan

- [ ] API daftar pelanggan toko dengan pencarian dan pagination.
- [ ] API detail pelanggan dan riwayat pesanan.
- [ ] API tambah dan ubah pelanggan dari desktop.
- [ ] API hapus atau nonaktifkan pelanggan sesuai kebutuhan.

### Pesanan

- [ ] API daftar pesanan dengan filter status, toko, dan rentang tanggal.
- [ ] API detail pesanan.
- [ ] API buat pesanan dari Admin Toko.
- [ ] API buat pesanan dari pelanggan web.
- [ ] Hitung subtotal dan total di server, bukan dari input frontend saja.
- [ ] API ubah status: Baru, Proses, Siap Diambil, Dalam Perjalanan, Selesai, Dibatalkan.
- [ ] API ubah status pembayaran: Belum Dibayar, Dibayar, Dikembalikan.
- [ ] Buat nomor pesanan unik seperti `LD-24018`.
- [ ] Catat perubahan status ke audit log.
- [ ] Hindari pesanan ganda ketika tombol disimpan dua kali.

Hasil tahap: seluruh data operasional utama tersimpan di PostgreSQL dan aman menurut role.

---

## Tahap 7 — Hubungkan frontend admin ke API

Tujuan: Desktop tidak lagi memakai data contoh pada fitur utama.

- [ ] Konfigurasi URL API melalui environment variable frontend.
- [ ] Buat HTTP client dengan token Authorization.
- [ ] Tambahkan TanStack Query untuk pengambilan, cache, dan pembaruan data.
- [ ] Tambahkan Zustand hanya untuk state UI dan sesi yang diperlukan.
- [ ] Hubungkan metrik dashboard ke endpoint laporan.
- [ ] Hubungkan grafik pesanan mingguan ke data API.
- [ ] Hubungkan target pendapatan bulanan ke data toko.
- [ ] Hubungkan aktivitas terbaru ke audit log dan pesanan terbaru.
- [ ] Hubungkan daftar pesanan dengan pencarian, filter, pagination, dan detail.
- [ ] Hubungkan Buat Pesanan tiga langkah ke pelanggan dan layanan nyata.
- [ ] Hubungkan halaman pelanggan desktop ke API.
- [ ] Hubungkan halaman layanan dan tarif ke API.
- [ ] Tambahkan modal konfirmasi untuk tindakan hapus atau pembatalan pesanan.
- [ ] Tambahkan toast berhasil/gagal.
- [ ] Tambahkan loading skeleton, empty state, dan error state di setiap halaman data.
- [ ] Tangani token habis atau tidak valid dengan logout yang jelas.

Hasil tahap: Admin Toko dapat menyelesaikan alur dari login sampai pesanan tersimpan.

---

## Tahap 8 — Modul manajemen admin

Tujuan: semua item navigasi desktop memiliki fungsi sesuai PRD.

### Jadwal antar-jemput

- [ ] Tentukan model data jadwal dan relasinya ke pesanan.
- [ ] Buat API jadwal penjemputan/pengantaran.
- [ ] Buat tampilan agenda dan daftar jadwal.
- [ ] Buat status jadwal: Dijadwalkan, Dalam Perjalanan, Selesai, Dibatalkan.

### Komplain

- [ ] API membuat komplain pelanggan.
- [ ] API daftar dan filter komplain admin.
- [ ] API balas komplain.
- [ ] API mengubah status komplain.
- [ ] Tambahkan riwayat balasan bila diperlukan.

### Laporan

- [ ] API ringkasan pelanggan, pesanan, pendapatan, layanan terlaris, dan pelanggan aktif.
- [ ] Filter Hari Ini, Minggu Ini, Bulan Ini, dan rentang tanggal.
- [ ] Grafik pesanan dan pendapatan berbasis data nyata.
- [ ] Endpoint ekspor CSV.
- [ ] Unduh CSV dari desktop melalui Tauri dan dari web melalui browser.

### Riwayat audit

- [ ] Catat login, perubahan layanan, pembuatan pesanan, perubahan status, dan pengaturan toko.
- [ ] API filter berdasarkan tanggal, pengguna, dan aksi.
- [ ] Tampilkan pagination di desktop.

### Profil dan pengaturan

- [ ] Ubah nama, telepon, dan avatar profil.
- [ ] Ubah kata sandi dengan validasi kata sandi lama.
- [ ] Atur preferensi notifikasi.
- [ ] Atur nama, alamat, jam operasional, telepon, dan lokasi toko.

Hasil tahap: semua menu utama desktop berfungsi dan memiliki data nyata.

---

## Tahap 9 — Web pelanggan dan peta

Tujuan: pelanggan dapat memilih toko, membuat pesanan, dan memantaunya.

- [ ] Buat register dan login pelanggan memakai API.
- [ ] Buat halaman pencarian toko.
- [ ] Minta izin lokasi perangkat dengan penanganan saat izin ditolak.
- [ ] Tentukan penyedia peta untuk demo: Leaflet + OpenStreetMap direkomendasikan karena gratis.
- [ ] Tampilkan penanda toko dari latitude/longitude database.
- [ ] Hitung dan urutkan toko berdasarkan jarak pelanggan.
- [ ] Buat fallback pencarian lokasi manual ketika GPS tidak tersedia.
- [ ] Tampilkan layanan aktif dari toko yang dipilih.
- [ ] Buat form pesanan pelanggan.
- [ ] Buat halaman ringkasan dan konfirmasi pesanan.
- [ ] Buat halaman riwayat pesanan.
- [ ] Buat detail dan pelacakan status pesanan.
- [ ] Buat halaman profil pelanggan.
- [ ] Buat formulir komplain pelanggan.
- [ ] Pastikan seluruh halaman nyaman di lebar mobile.

Hasil tahap: pelanggan dapat menyelesaikan pesanan mandiri lewat web.

---

## Tahap 10 — Desain, aset, dan pengalaman pengguna

Tujuan: hasil terasa konsisten dan siap dinilai.

- [ ] Tetapkan token warna final: biru tua, biru muda, putih, abu-abu; hijau khusus keberhasilan.
- [ ] Perbarui dokumen lama yang masih mewajibkan hijau sebagai warna utama.
- [ ] Tambahkan logo Laundry Desk ke halaman login, loading, dan navigasi.
- [ ] Buat ikon kecil versi sederhana dari logo untuk sidebar dan favicon.
- [ ] Tambahkan ilustrasi laundry yang rapi ke login/loading desktop tanpa menutupi form.
- [ ] Pastikan ilustrasi tidak bertumpuk dan semua layer Figma rapi sebagai referensi.
- [ ] Samakan komponen: tombol, input, kartu, tabel, badge, dialog, toast, dan progress.
- [ ] Tambahkan focus state keyboard dan label aksesibilitas untuk tombol ikon.
- [ ] Pastikan kontras teks cukup dibaca.
- [ ] Perbaiki responsif web mobile dan desktop 1440px.
- [ ] Buat state loading, kosong, sukses, dan gagal untuk fitur penting.

Hasil tahap: desain konsisten dengan identitas Laundry Desk dan nyaman dipakai.

---

## Tahap 11 — Tauri, build, dan demo lokal

Tujuan: desktop benar-benar dapat dijalankan sebagai aplikasi Windows.

- [ ] Pasang Rust stable dan verifikasi `cargo`.
- [ ] Pasang WebView2 Runtime bila belum tersedia.
- [ ] Jalankan Tauri dalam mode development.
- [ ] Hubungkan penyimpanan token desktop ke plugin penyimpanan aman Tauri.
- [ ] Tambahkan notifikasi sistem untuk pesanan baru jika waktu memungkinkan.
- [ ] Tambahkan ekspor laporan melalui filesystem Tauri.
- [ ] Uji jendela, ukuran minimum, dan judul aplikasi.
- [ ] Buat build installer Windows `.msi` atau `.exe`.
- [ ] Instal installer pada komputer uji.

Hasil tahap: Admin dapat menjalankan Laundry Desk tanpa membuka browser.

---

## Tahap 12 — Pengujian dan perbaikan akhir

Tujuan: demo tidak gagal pada alur utama.

- [ ] Test API login, logout, role, toko, layanan, pelanggan, pesanan, komplain, laporan, dan audit.
- [ ] Test validasi API untuk input tidak lengkap dan data tidak valid.
- [ ] Test role Admin Toko tidak dapat membaca data toko lain.
- [ ] Test role Pelanggan tidak dapat membuka API admin.
- [ ] Test login, buat pesanan, ubah status, dan riwayat pesanan dari awal sampai akhir.
- [ ] Test data kosong pada semua daftar.
- [ ] Test error koneksi database/API menampilkan pesan yang jelas.
- [ ] Test tombol simpan tidak menyebabkan data ganda.
- [ ] Test pencarian, filter, tanggal, dan pagination.
- [ ] Test layar desktop dan mobile.
- [ ] Jalankan production build frontend kembali.
- [ ] Jalankan migration dari database kosong dan seeder.
- [ ] Periksa log Laravel untuk error.
- [ ] Perbaiki semua error kritis sebelum demo.

Hasil tahap: alur utama lolos pengujian dan tidak menampilkan error pada demo.

---

## Tahap 13 — Materi demo dan pengumpulan tugas

Tujuan: project mudah dinilai dan mudah dijalankan penguji.

- [ ] Buat README proyek berisi tujuan, fitur, teknologi, struktur, dan cara menjalankan.
- [ ] Tulis prasyarat: Node.js, PHP, Composer, PostgreSQL, Rust untuk desktop.
- [ ] Buat `.env.example` tanpa password atau token rahasia.
- [ ] Tulis langkah membuat database, migration, seeder, dan menjalankan backend/frontend.
- [ ] Buat akun demo beserta role dan password yang aman untuk presentasi.
- [ ] Tulis daftar endpoint API penting.
- [ ] Buat diagram arsitektur: Web dan Desktop → Laravel API → PostgreSQL.
- [ ] Ambil screenshot login, dashboard, pesanan, pelanggan, peta, dan laporan.
- [ ] Siapkan slide 5–7 halaman: masalah, solusi, fitur, arsitektur, demo, teknologi, kesimpulan.
- [ ] Buat naskah demo 3–5 menit.
- [ ] Buat urutan demo: login Admin Toko → buat pesanan → ubah status → login pelanggan → lihat riwayat → pilih outlet peta.
- [ ] Simpan backup database dan source code sebelum presentasi.
- [ ] Uji seluruh alur demo di laptop yang akan dipakai presentasi.

Hasil tahap: project siap dikumpulkan dan dipresentasikan.

---

## Definisi selesai untuk demo final

Project dianggap siap ketika:

- Desktop dan web dapat dibangun tanpa error.
- Database dapat dibuat dengan migration dan seeder.
- Tiga peran dapat login memakai API.
- Admin Toko dapat membuat, melihat, dan memperbarui pesanan nyata.
- Pelanggan dapat memilih toko, membuat pesanan, dan melihat riwayat.
- Role tidak dapat mengakses data yang bukan miliknya.
- Semua menu demo menampilkan data, state kosong, atau pesan yang masuk akal.
- Installer desktop atau mode development siap ditunjukkan.
- README, akun demo, screenshot, dan naskah presentasi tersedia.

# Design Brief Figma — LaundryKita

Dokumen ini menjadi brief desain untuk membuat acuan visual tiga halaman aplikasi LaundryKita di Figma. Gunakan sebagai sumber spesifikasi; bila kolom AI Figma membatasi panjang prompt, salin ringkasan per halaman dan gunakan dokumen ini sebagai referensi.

## Tujuan

Buat desain UI aplikasi marketplace laundry dengan tiga frame utama: **Login**, **Dashboard Admin**, dan **Buat Pesanan**. Desain harus bisa menjadi acuan implementasi React, TypeScript, dan Tailwind CSS. Prioritaskan alur yang jelas, keterbacaan, dan konsistensi komponen.

## Referensi dan karakter visual

- Situs referensi suasana dan warna: [Chingu Laundry — Layanan](https://chingu-laundry.com/#layanan).
- Ambil kesan bersih, segar, cepat, ramah, dan praktis. Gunakan warna toska/mint sebagai inspirasi.
- Jangan menyalin logo, ilustrasi, teks, atau tata letak Chingu Laundry. Buat identitas visual LaundryKita sendiri.
- Pertahankan warna utama produk `#10B981` untuk tombol dan aksi penting. Palet pendukung: biru gelap `#0F172A`, latar `#F8FAFC`, putih `#FFFFFF`, teks sekunder `#64748B`, aksen peringatan `#F59E0B`, dan bahaya `#EF4444`. Toska/mint boleh dipakai sebagai aksen sekunder.
- Nuansa lucu berasal dari ilustrasi kecil, ikon bersahabat, bentuk lembut, dan microcopy hangat. Tetap terlihat profesional untuk aplikasi operasional harian.
- Gunakan font sans-serif yang jelas, jarak lega, kartu radius 8–16 px, bayangan tipis, ikon sederhana, dan kontras teks yang baik.
- Hindari gaya kekanak-kanakan, terlalu banyak dekorasi, warna neon, gradient mencolok, tabel padat, atau teks terlalu kecil.
- Semua label, tombol, contoh data, dan pesan menggunakan Bahasa Indonesia. Gunakan format Rupiah, misalnya `Rp 48.000`.

## Frame dan konsistensi

Buat satu file desain dengan tiga frame desktop berukuran konsisten, serta satu frame tambahan versi mobile untuk halaman Buat Pesanan. Gunakan grid dan jarak yang konsisten. Buat komponen berulang (tombol, input, badge status, kartu, navigasi) dengan gaya yang sama. Tampilkan variasi state penting: fokus input, tombol utama, status online, badge status, validasi form, dan state kosong jika relevan.

## Halaman 1 — Login

Buat halaman login admin yang sederhana dan menyambut.

- Tampilkan identitas teks **LaundryKita** dan sapaan singkat.
- Form berisi input **Email atau Username**, **Kata Sandi**, checkbox **Ingat saya**, tautan **Lupa kata sandi?**, dan tombol utama **Masuk**.
- Tampilkan contoh pesan validasi yang ringkas dan ramah serta state tombol sedang memproses.
- Tambahkan ilustrasi kecil bertema pakaian bersih, gelembung, atau mesin cuci sebagai aksen. Jangan sampai ilustrasi mengganggu fokus pada form.
- Pastikan form mudah dipindai, punya label yang jelas, dan terlihat nyaman digunakan dalam sesi kerja sehari-hari.

## Halaman 2 — Dashboard Store Admin

Buat dashboard desktop admin toko dengan navigasi yang jelas dan konten yang mudah dipindai.

- Sidebar tetap, lebar sekitar 240 px, warna biru gelap. Kelompok **OPERASIONAL**: Beranda, Buat Pesanan, Daftar Pesanan, Pelanggan, Jadwal Antar-Jemput. Kelompok **MANAJEMEN**: Layanan & Tarif, Komplain, Laporan, Riwayat Audit. Tandai menu aktif dengan hijau utama.
- Top bar berisi judul halaman, indikator koneksi **Online**, ikon notifikasi dengan badge, dan dropdown cabang.
- Buat enam kartu metrik: **Pesanan Hari Ini**, **Pendapatan Hari Ini**, **Pesanan Baru**, **Sedang Dicuci**, **Siap Diambil**, dan **Dalam Perjalanan**. Gunakan angka dan perubahan contoh yang masuk akal; bedakan status positif, perhatian, dan netral dengan warna yang konsisten.
- Tambahkan progres target bulanan dengan nilai Rupiah dan persentase.
- Tambahkan grafik pesanan mingguan dengan label hari Indonesia dan filter **7 hari / 30 hari / Semua**.
- Tambahkan daftar **Aktivitas Terbaru** berisi lima item, waktu relatif, dan penanda status.
- Ilustrasi laundry boleh hadir sebagai aksen kecil. Jangan mengurangi ruang untuk metrik dan grafik.

## Halaman 3 — Buat Pesanan

Buat alur tiga langkah. Indikator progres menampilkan langkah aktif dengan jelas.

1. **Pilih Pelanggan**
   - Kolom pencarian dengan placeholder **Cari pelanggan berdasarkan nama/telepon...**.
   - Kartu pelanggan berisi inisial/avatar, nama, telepon atau jumlah pesanan sebelumnya, dan tombol **Pilih**.
   - Sediakan state kosong **Tidak ada pelanggan terdaftar**.
2. **Layanan & Berat/Qty**
   - Tampilkan layanan yang dipilih sebagai baris yang mudah dibaca: nama layanan, deskripsi singkat, harga, satuan (kg/unit), input jumlah, subtotal, dan aksi hapus.
   - Sediakan aksi **Tambah layanan**, total sementara yang menonjol, serta pilihan pembayaran **Cash**, **Transfer**, dan **Dana/GoPay**.
   - Input jumlah harus jelas dan menyediakan state fokus/validasi.
3. **Ringkasan & Pembayaran**
   - Tampilkan pelanggan, layanan, jumlah, subtotal, metode pembayaran, dan total harga.
   - Sediakan konfirmasi **Anda yakin ingin memesan?**, tombol **Batal**, dan tombol utama **Konfirmasi Pesanan**.

- Tombol **Kembali** dan **Lanjut** untuk navigasi antar langkah. Pada langkah terakhir, tampilkan tombol konfirmasi.
- Buat tata letak yang efisien untuk staf toko; jumlah dan total harus mudah ditemukan tanpa menggulir berlebihan.
- Sertakan contoh validasi dan state pesanan yang belum memiliki layanan.
- Buat versi mobile: navigasi langkah tetap jelas, kartu layanan tersusun vertikal, total dan aksi utama mudah dijangkau.

## Hasil yang diharapkan

- Empat frame: tiga desktop (Login, Dashboard Admin, Buat Pesanan) dan satu mobile (Buat Pesanan).
- Sistem warna, tipografi, jarak, ikon, tombol, kartu, dan badge status yang konsisten.
- Desain bersih, lucu secukupnya, profesional, dan realistis untuk aplikasi laundry Indonesia.
- Gunakan data contoh, bukan lorem ipsum. Teks antarmuka singkat dan natural.
- Jadikan hasil sebagai mockup yang bisa ditinjau dan diedit di Figma; jangan menghasilkan kode sebagai keluaran desain.

# Prompt Revisi Desain Figma — Mode Gelap & Grafik Trading

Gunakan file Figma yang sudah ada sebagai dasar. Revisi desain yang ada, jangan membuat ulang seluruh aplikasi atau menambah halaman baru. Pertahankan alur dan fungsi halaman Login, Dashboard Admin, dan Buat Pesanan. Buat tampilannya lebih matang dan spesifik untuk aplikasi operasional laundry, dengan **mode gelap** dan **grafik garis bergaya terminal trading/saham** pada dashboard.

## Arah visual

- Gunakan dark UI yang nyaman dibaca: latar utama biru-hitam/arang (`#0B1220` atau `#0F172A`), panel sedikit lebih terang (`#111B2E` / `#172033`), garis batas tipis (`#263449`), teks utama putih lembut (`#E5EAF2`), teks sekunder abu kebiruan (`#91A0B5`).
- Pertahankan hijau LaundryKita `#10B981` sebagai warna utama untuk aksi dan data positif. Gunakan mint hanya sebagai aksen. Merah `#EF4444` untuk penurunan/error dan amber `#F59E0B` untuk menunggu/perlu perhatian.
- Pastikan kontras kuat. Hindari abu-abu terlalu gelap untuk teks, glow berlebihan, gradient neon, dan terlalu banyak warna aksen.
- Gaya harus terasa seperti produk SaaS/POS yang dirancang matang: padat secukupnya, rapi, fungsional, dan punya identitas. Kurangi ciri hasil template generik: jangan memakai kartu seragam berlebihan, ikon dekoratif tanpa fungsi, ilustrasi lucu besar, heading pemasaran, emoji acak, atau banyak pill/badge.
- Gunakan tipografi sans-serif yang jelas, hirarki ukuran yang realistis, spacing konsisten, radius moderat, dan garis pemisah halus. Gunakan ikon sederhana dengan ukuran konsisten.
- Pertahankan Bahasa Indonesia dan data laundry yang sudah ada. Jangan mengganti fungsi, label inti, atau struktur navigasi tanpa alasan.

## Revisi Dashboard — Grafik trading

Ganti grafik area/line chart biasa dengan grafik garis yang terinspirasi terminal trading modern. Grafik menunjukkan **jumlah pesanan harian** atau metrik yang sudah dipakai dashboard; jangan mengubah arti data secara diam-diam.

- Buat satu garis utama berwarna mint/hijau terang, tipis tetapi jelas, dengan perubahan nilai yang tampak alami dan tidak terlalu halus.
- Tambahkan sumbu waktu yang rapi (misalnya Sen, Sel, Rab, Kam, Jum, Sab, Min) dan label nilai yang sesuai dengan metrik. Grid horizontal tipis dan redup.
- Tambahkan crosshair vertikal/horizontal saat titik dipilih, titik data aktif, dan tooltip gelap yang menampilkan tanggal, nilai, serta perubahan dari periode sebelumnya jika datanya tersedia.
- Sertakan ringkasan kecil di bagian atas grafik: nilai saat ini, perubahan absolut/persentase, dan label periode. Gunakan hijau untuk kenaikan dan merah untuk penurunan; jangan mengandalkan warna saja—sertakan tanda `+`/`−` atau teks.
- Sediakan pilihan periode seperti **7 hari**, **30 hari**, dan **Semua** sebagai kontrol kecil yang jelas.
- Hindari efek glow kuat, gradient area besar, banyak seri yang bertumpuk, tick rapat, angka palsu yang tampak terlalu presisi, dan dekorasi candlestick. Hasil harus terasa seperti grafik trading tetapi tetap cocok untuk data bisnis laundry.
- Jika Figma tidak mendukung interaksi asli, tunjukkan satu state statis dengan crosshair dan tooltip aktif sebagai contoh.

## Penyesuaian tiap halaman

### Login

- Terapkan latar gelap dan panel form kontras yang bersih.
- Pertahankan form email/username, kata sandi, ingat saya, lupa kata sandi, dan tombol masuk.
- Gunakan aksen laundry secukupnya, misalnya simbol gelembung/serat kain yang sangat halus atau wordmark sederhana. Hindari ilustrasi besar atau gaya kartun.
- Pastikan input, placeholder, fokus, error, dan tombol tetap jelas di mode gelap.

### Dashboard Admin

- Terapkan sidebar gelap yang sedikit berbeda dari latar konten agar batas area mudah dikenali. Menu aktif memakai aksen hijau yang terukur.
- Pertahankan top bar, status koneksi, notifikasi, pemilih cabang, enam metrik, target bulanan, grafik, dan aktivitas terbaru.
- Kartu metrik harus ringkas dan informatif: label, angka utama, indikator perubahan bila relevan, dan ikon kecil fungsional.
- Jadikan grafik trading sebagai fokus data utama tanpa membuat kartu lain berkompetisi dengannya.
- Status pesanan gunakan warna yang konsisten dan kontras baik pada latar gelap.

### Buat Pesanan

- Pertahankan alur tiga langkah: **Pilih Pelanggan**, **Layanan & Berat/Qty**, **Ringkasan & Pembayaran**.
- Pastikan progress step, kartu pelanggan, baris layanan, input jumlah, subtotal, total, metode pembayaran, dan tombol navigasi terbaca jelas dalam mode gelap.
- Gunakan permukaan panel yang berbeda tipis dari latar. Border input harus terlihat tanpa menjadi terlalu terang.
- Tombol utama hijau; tombol sekunder netral. State validasi/error harus mudah dipahami.
- Pada versi mobile, pertahankan hierarki dan tombol aksi utama tetap mudah ditemukan.

## Hasil yang diminta

- Revisi frame yang ada untuk Login, Dashboard Admin, dan Buat Pesanan; pertahankan frame mobile bila sudah tersedia.
- Buat satu sistem dark theme yang konsisten untuk warna, teks, input, tombol, kartu, tabel, badge, dan grafik.
- Tampilkan grafik trading dengan tooltip/crosshair sebagai contoh state.
- Jaga desain tetap realistis untuk diimplementasikan dengan React dan Tailwind CSS.
- Jangan menambahkan lorem ipsum, klaim pemasaran, angka yang tidak konsisten, atau komponen dekoratif yang tidak membantu pengguna.

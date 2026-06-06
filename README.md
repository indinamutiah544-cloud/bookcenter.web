# Book Store Center

**Book Store Center** adalah platform sistem informasi toko buku online berbasis *website* yang dibangun untuk mempermudah pengguna mencari, membeli, dan mengelola pesanan buku. Aplikasi ini dilengkapi dengan sistem Admin yang *powerful* dan antarmuka pengguna (UI) yang modern serta responsif.

Proyek ini dibangun sebagai pemenuhan Tugas Mata Kuliah **Pemrograman Web Dasar** di **Universitas Muhammadiyah Sumatera Utara**.

---

## Fitur Utama

### Fitur Pengguna (User)
- **Katalog Buku Interaktif**: Menampilkan koleksi buku yang tersedia lengkap dengan harga dan stok.
- **Keranjang Belanja**: Sistem penambahan buku ke dalam keranjang belanja dan penyesuaian kuantitas secara langsung.
- **Checkout & Riwayat Pesanan**: Proses *checkout* pesanan yang mudah dengan sistem pelacakan status (*Pending*, Diproses, Dikirim, Selesai).
- **Manajemen Profil**: Pengguna dapat memperbarui nama, nomor telepon, alamat pengiriman (untuk pengiriman buku), dan password.
- **Mode Gelap Sempurna (Dark Mode)**: Mendukung pergantian tema gelap dan terang secara *smooth* untuk kenyamanan mata pengguna.
- **Responsif**: Tampilan tetap rapi dan optimal saat diakses menggunakan *smartphone*, tablet, maupun *desktop*.

### Fitur Administrator
- **Dashboard Analitik**: Menampilkan ringkasan total pendapatan, jumlah buku, daftar pesanan terbaru, dan jumlah pelanggan terdaftar.
- **Manajemen Kategori**: Menambah, mengubah, dan menghapus kategori buku.
- **Manajemen Buku**: Mengelola data inventaris buku secara penuh, termasuk manajemen gambar sampul (*cover*), harga, deskripsi produk, dan pembaruan sisa stok.
- **Manajemen Pesanan Masuk**: Memantau dan memperbarui status pesanan seluruh pengguna (*Pending* -> *Diproses* -> *Dikirim* -> *Selesai*).
- **Manajemen Pengguna**: Memantau dan mengelola daftar profil pengguna yang mendaftar di sistem.

---

## Teknologi Pendukung

Aplikasi ini dibangun menggunakan *stack* teknologi *native* tanpa framework yang berat demi memaksimalkan performa dasar dan efisiensi server:

- **Bahasa Pemrograman Backend**: PHP Native (Support PHP 8+)
- **Database**: MySQL
- **Frontend & UI**: Bootstrap 5.3.2
- **Custom Styling**: Native CSS3 (Dilengkapi custom arsitektur Dark Mode)
- **Icons**: Bootstrap Icons

---

## Tim Pengembang

**Kelompok 5**  

| Jabatan | Nama Lengkap | NPM |
| :--- | :--- | :--- |
| **Ketua** | Balqis Enggelin Iswanto | 2409010318 |
| **Anggota** | Andika Dwi Putra | 2409010010 |
| **Anggota** | Indina Mutiah | 2409010265 |
| **Anggota** | Farhan Ansyari | 2409010150 |
| **Anggota** | Ahmad Irsan Rambe | 2409010319 |

---

## Cara Instalasi & Menjalankan di Localhost

Ikuti langkah-langkah di bawah ini untuk menjalankan *project* ini di komputer lokal Anda:

1. **Persiapan Server**
   Pastikan Anda sudah meng-install XAMPP, Laragon, MAMP, atau *software* lokal server lainnya yang mendukung PHP dan MySQL.
   
2. **Clone / Download Repository**
   ```bash
   git clone https://github.com/Anang-Programmer/book_store_center.git
   ```
   Atau Anda bisa meletakkan *folder* *project* hasil *download* ke dalam direktori `htdocs` (bagi pengguna XAMPP) atau direktori `www` (bagi pengguna Laragon).
   
3. **Konfigurasi Database**
   - Buka `http://localhost/phpmyadmin`.
   - Buat *database* baru dengan nama `book_store_center`.
   - *Import* file SQL bawaan yaitu `book_store_center.sql` ke dalam *database* yang baru saja dibuat.
   - Pastikan konfigurasi di dalam file `config/koneksi.php` sesuai dengan kredensial database lokal Anda (biasanya user: `root` dan password kosong/tanpa password).
   
4. **Jalankan Aplikasi**
   Buka *web browser* (Chrome/Firefox/Safari) dan akses alamat berikut:
   ```text
   http://localhost/book_store_center
   ```
   *(Sesuaikan bagian /book_store_center/ dengan nama folder proyek Anda jika diubah)*

---

## Akun Akses (Testing)

Untuk mencoba masuk ke dalam panel **Admin** atau menguji proses pembelian secara langsung:

- **Akun Admin:**  
  Silakan membuat *user* secara manual lewat *register* lalu merubah status/role-nya menjadi `admin` melalui *database* (phpMyAdmin), atau langsung *login* jika sudah tersedia data admin *dummy* pada database bawaan SQL.

- **Akun User Pembeli:**  
  Anda dapat mendaftarkan akun baru kapan saja melalui fitur **Daftar/Register** di halaman utama untuk bertransaksi dan mengelola keranjang.

---

> Dibuat dengan Dedikasi oleh **Kelompok 5** - Pemrograman Web Dasar.

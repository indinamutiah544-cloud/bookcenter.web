-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2026 pada 18.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store_center`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `category_id`, `title`, `author`, `publisher`, `description`, `price`, `stock`, `cover_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Laskar Pelangi', 'Andrea Hirata', 'Goodreads', 'Novel Tes isi', 9999999999.99, 48, 'cover_1779592068.jpg', '2026-05-24 03:07:48', '2026-05-24 06:18:39'),
(2, 1, 'Time Lapse', 'Hesti Duwi', 'Umsu Press', 'Time Lapse adalah pilihan judul yang tepat untuk mewakili isi dari novel ini Perjalanan waktu antara dua remaja bernama Reiga dan Leona membawa banyak tanda tanya atas hubungan yang belum terbaca Time Lapse adalah pilihan judul yang tepat untuk mewakili isi dari novel ini. Perjalanan waktu antara dua remaja bernama Reiga dan Leona membawa banyak tanda tanya atas hubungan yang belum terbaca.', 96000.00, 5, 'cover_1779608519.jpeg', '2026-05-24 07:41:59', '2026-05-24 07:42:07'),
(3, 2, 'Atomic Habits', 'James Clear', 'Gramedia Pustaka Utama', 'Perubahan Kecil yang Memberikan Hasil Luar Biasa adalah buku kategori self improvement karya James Clear. Pada umumnya, perubahan-perubahan kecil seringkali terkesan tak bermakna karena tidak langsung membawa perubahan nyata pada hidup suatu manusia. Jika diumpamakan sekeping koin tidak bisa menjadikan kaya, suatu perubahan positif seperti meditasi selama satu menit atau membaca buku satu halaman setiap hari mustahil menghasilkan perbedaan yang bisa terdeteksi. Namun hal tersebut tidak sejalan dengan pemikiran James Clear, ia merupakan seorang pakar dunia yang terkenal dengan \'habits\' atau kebiasaan. Ia tahu bahwa tiap perbaikan kecil bagaikan menambahkan pasir ke sisi positif timbangan dan akan menghasilkan perubahan nyata yang berasal dari efek gabungan ratusan bahkan ribuan keputusan kecil. Ia menamakan perubahan kecil yang membawa pengaruh yang luar biasa dengan nama atomic habits.', 87000.00, 7, 'cover_1779609201.jpeg', '2026-05-24 07:53:21', '2026-05-24 07:53:21'),
(4, 3, 'Dari Penjara Ke Penjara', 'Tan Malaka', 'Narasi', 'autobiografi tiga jilid yang ditulis oleh tokoh revolusioner Indonesia, Tan Malaka, pada tahun 1948. Karya ini mendokumentasikan pelariannya, perjuangan politiknya, dan pemikirannya saat ia berpindah dari penjara satu ke penjara lainnya di berbagai negara.', 95000.00, 3, 'cover_1779609405.jpeg', '2026-05-24 07:56:45', '2026-05-24 07:56:45'),
(5, 1, 'Hello', 'Tere Liye', 'SabakGrip Nusantara', 'KISAH DISAH ini sudah tertinggal puluhan tahun lebih. Maka ibarat seseorang yang ketinggalan kereta, bukan cuma kilau lampu dan getar rel yang telah hilang di tikungan sana, bahkan gerbong dan lokomotifnya sudah karatan dipensiunkan.\r\nCerita ini sudah menguap puluhan tahun lebih. Maka ibarat embun menggelayut malas di daun rumput, rerumputan itu sudah menjadi hutan, tidak tersisa lagi kenangannya.\r\nTetapi tak mengapa. Meskipun sudah tertinggal jauh, boleh jadi cerita ini menyenangkan untuk dibaca.\r\nJangan terlalu berharap banyak saat membaca kisah ini. Sungguh jangan. Karena ketahuilah, sumber ketidakbahagiaan besar di dunia adalah: berharap-lebih-lebih saat kita berharap terlalu banyak. Ketika hasilnya tidak sesuai, muncullah kecewa. Akan beda jadinya jika kita tidak berharap, apa pun hasilnya, kita tetap baik-baik saja. Apalagi saat akhirnya sangat spesial, kita akan lega sekali.\r\nSinopsis\r\nHello Apakah kamu di sana? Aku tahu kamu di sana. Aku tahu kamu mendengarkan suaraku.\r\nHello Aku tahu kita belum bisa bicara. Tapi aku tidak bisa menahan diriku untuk meneleponmu. Aku hanya hendak bilang, aku tidak akan menyerah.\r\nAku akan selalu menyayangimu.\r\nRAMA gadis usia 24 tahun itu adalah Ana. Wajahnya cantik, tubuhnya tinggi. Kalian akan tertipu jika hanya melihat tampilan luarnya. Dia bukan gadis biasa.\r\n\r\nYang pertama, pekerjaannya adalah tukang bangunan. Catat itu baik-baik: tukang bangunan.\r\n\r\nAna lulus dari kuliahnya di teknik sipil tiga tahun lalu. Tidak seperti teman-teman kampusnya yang melamar pekerjaan di kantor atau perusahaan besar, Ana memutuskan bekerja untuk dirinya sendiri, sekaligus kuliah lagi di jurusan arsitektur.\r\nPekerjan awalnya kecil, hanya diminta memperbaiki pagar rusak oleh tetangga, menambal tembok retak, atau mengganti keramik kamar mandi yang kusam. Dia sendiri yang melakukannya. Menyeret ember berisi adonan semen, mulai memasang ubin. Berlepotan di tangan, wajah, rambut, tidak masalah, dia tetap semangat.', 99000.00, 3, 'cover_1779609730.jpeg', '2026-05-24 08:02:10', '2026-05-24 09:43:40'),
(6, 1, 'Dompet Ayah Sepatu Ibu', 'J.S Khairen', 'Gramedia Widiasarana Indonesia (Grasindo) ', ' Zenna lahir urutan keenam dari sebelas saudara. Ia bersama keluarganya tinggal di punggung gunung Singgalang. Saat kecil, Zenna sudah bekerja keras untuk hidup. Ia pergi ke sekolah dengan sepatu rombeng naik-turun gunung sambil membawa jagung rebus untuk dijual. “Besok Abak belikan sepatu baru kalau sudah dapat uang,” janji Abaknya pada Zenna sebelum berangkat ke sekolah. Namun tak sempat Abak tunaikan janji itu. Abak meninggalkan Zenna untuk selamanya, juga meninggalkan janjinya pada Zenna untuk membelikan sepatu. Sebagai anak tengah-tengah, Zenna jarang mendapat perhatian. Ia menumpahkan kesedihannya pada dirinya sendiri. Ia bekerja keras dengan mandiri. Ia ingin melanjutkan janji Abaknya untuk membelikan sepatu. Ia membeli sepatu untuk dirinya sendiri. Di punggung gunung yang lain, gunung Marapi, Asrul dan adiknya Irsal harus membantu Umi untuk menghidupi diri. Bapaknya menikah lagi dan tinggal di rumah bersama istri keduanya, sehingga Umi, Asrul, dan Irsal pindah ke rumah peninggalan orang tua Umi. Berpisah dari Bapak. Meski Bapak kadang memberi mereka uang, itu tidaklah cukup. Setiap kali Asrul diberi uang oleh Bapak, Asrul selalu mengintip dompetnya, ada kayu manis yang diselipkan Bapak di sana. Asrul tak punya dompet karena ia tak pernah memegang uang. Bila pun dia punya, akan ia berikan pada Umi. Asrul ingin membuatkan rumah untuk Umi suatu saat kelak. Asrul dan Zenna akhirnya bertemu. Mereka berdua bertekad mengangkat derajat dirinya dan keluarganya ke kehidupan yang lebih baik. Mereka bertemu di kampus. Koran Harian Semangat turut merekatkan hubungan mereka. Hingga kelak mereka menikah dan memiliki rumah. Umi dan Umak mereka bawa tinggal bersama. Kehidupan mereka walau sudah lebih baik, tidak juga mudah. Musibah datang berkali-kali. “Kita pernah melewati yang lebih buruk dari ini,” kata mereka saling menguatkan.', 90000.00, 8, 'cover_1779609866.jpeg', '2026-05-24 08:04:26', '2026-05-24 08:04:26'),
(7, 4, ' Lucunya Prabowo: Tegas, Santuy, Ikhlas, dan Senyumin Aja', 'Ahmad Subagya Sunano', 'Kompas Penerbit Buku', 'Merangkum cerita-cerita personal yang jarang ditampakkan\r\ndi depan umum, Lucunya Prabowo: Tegas, Santuy,\r\nIkhlas, dan Senyumin Aja menunjukkan pribadi\r\nPrabowo\r\nyang dikenal orang-orang terdekatnya. Terlepas dari\r\ntanggung\r\njawabnya yang besar dalam mengusung berbagai isu\r\nsosial, politik, dan keamanan, image Prabowo kini dikenal sebagai\r\npemimpin yang gaul dan dekat dengan masyarakat. Menariknya,\r\nia selalu bisa menempatkan setiap gurau sembari mempertahankan\r\nkesantunannya kepada senior, guru, hingga masyarakat luas.', 133000.00, 8, 'cover_1779610003.jpeg', '2026-05-24 08:06:43', '2026-05-24 09:50:05'),
(8, 3, 'Cerita Dika Pendek', 'Andika', 'Indina - Balqis', 'Andi seorang mahasiswa yang disukai lelaki A2', 10.00, 2, 'cover_1779616665.jpeg', '2026-05-24 09:57:45', '2026-05-24 09:57:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `book_id`, `quantity`, `created_at`) VALUES
(9, 3, 8, 1, '2026-05-24 09:58:41'),
(10, 2, 2, 1, '2026-05-24 11:57:10'),
(11, 2, 7, 1, '2026-05-24 12:24:45'),
(12, 2, 8, 1, '2026-05-24 14:08:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Novel', 'novel', '2026-05-24 03:05:42'),
(2, 'Self - Improvement', 'self---improvement', '2026-05-24 07:51:01'),
(3, 'Non Fiksi', 'non-fiksi', '2026-05-24 07:54:33'),
(4, 'Biografi - Politik/Sosial', 'biografi---politik-sosial', '2026-05-24 08:05:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('pending','waiting_verification','processing','shipped','completed','cancelled') DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `invoice_number`, `user_id`, `total_amount`, `status`, `payment_proof`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 'INV-20260524-963C0', 2, 100000.00, 'shipped', 'proof_INV-20260524-963C0_1779592197.jpg', 'Jalan Lupa', '2026-05-24 03:08:43', '2026-05-24 03:10:49'),
(2, 'INV-20260524-56E3F', 2, 9999999999.99, 'shipped', 'proof_INV-20260524-56E3F_1779603600.jpeg', 'Jalan Lupa', '2026-05-24 06:18:39', '2026-05-24 09:45:53'),
(3, 'INV-20260524-101A7', 2, 99000.00, 'pending', NULL, 'Jalan Lupa', '2026-05-24 09:43:40', '2026-05-24 09:43:40'),
(4, 'INV-20260524-2F346', 3, 133000.00, 'completed', 'proof_INV-20260524-2F346_1779616217.jpeg', 'lupa', '2026-05-24 09:50:05', '2026-05-24 09:51:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `book_id`, `quantity`, `price_at_purchase`) VALUES
(1, 1, 1, 1, 100000.00),
(2, 2, 1, 1, 9999999999.99),
(3, 3, 5, 1, 99000.00),
(4, 4, 7, 1, 133000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `is_suspended` tinyint(1) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_suspended`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Balqis Enggelin Iswanto', 'balqis@gmail.com', '$2y$10$Mr7p0v.ZZkig45t2SZoyj.KfTud751XuvujhWm6S5WJ5R4IjexxRy', 'admin', 0, '240901318', 'Jalan apa aja', '2026-05-24 00:17:34', '2026-05-24 00:19:35'),
(2, 'Indina Mutiah', 'indina@gmail.com', '$2y$10$.UkeRjxiitmP3QHHbSrlqOfWU16PYPqHJYDLq3yaIf1vzVzFFoEnK', 'user', 0, '2409010265', 'Jalan Lupa', '2026-05-24 03:04:49', '2026-05-24 12:51:32'),
(3, 'rambe', 'rambe@gmail.com', '$2y$10$WiMBTvS.i0tY9A7Ygyy9wehqNGAqEZHmfGdC/wQsQ0G.oSxRcs5RC', 'user', 0, '2409010265', 'lupa', '2026-05-24 06:47:38', '2026-05-24 06:47:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_book_unique` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

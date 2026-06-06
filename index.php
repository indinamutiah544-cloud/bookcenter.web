<?php
// Panggil koneksi dan header
require_once 'config/koneksi.php';
require_once 'includes/header.php';

// Filter builder
$where_clauses = [];
if (isset($_GET['cari']) && trim($_GET['cari']) != '') {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $where_clauses[] = "(books.title LIKE '%$cari%' OR books.author LIKE '%$cari%')";
}
if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
    $kategori_id = (int)$_GET['kategori'];
    $where_clauses[] = "books.category_id = $kategori_id";
}

$where_sql = "";
if (count($where_clauses) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where_clauses);
}

// Query utama
$query = "SELECT books.*, categories.name AS category_name 
          FROM books 
          LEFT JOIN categories ON books.category_id = categories.id 
          $where_sql
          ORDER BY books.id DESC";
$result = mysqli_query($koneksi, $query);

// Ambil data kategori untuk filter
$query_kat = "SELECT * FROM categories ORDER BY name ASC";
$result_kat = mysqli_query($koneksi, $query_kat);
?>

<!-- Welcome Banner -->


<!-- <?php if (isset($_SESSION['user_id'])): ?>
    <div class="alert alert-primary border-0 shadow-sm p-4 mb-4 rounded-3 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="alert-heading fw-bold mb-1">Hai, <?= htmlspecialchars($_SESSION['name']) ?>!</h4>
            <p class="mb-0 text-secondary">Selamat datang kembali di <strong>Book Store Center</strong>. Temukan dan dapatkan koleksi buku impian Anda sekarang!</p>
        </div>
        <div class="d-none d-md-block">
            <a href="riwayat.php" class="btn btn-primary btn-sm fw-bold">Pesanan Anda</a>
            <a href="cart.php" class="btn btn-light btn-sm text-primary fw-bold ms-2">Keranjang</a>
        </div>
    </div>
<?php else: ?>
    <div class="bg-primary text-white p-4 mb-4 rounded-3 shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
        <div class="position-relative z-1">
            <h4 class="fw-bold mb-1">Selamat Datang di Book Store Center!</h4>
            <p class="mb-3 opacity-90">Silakan masuk atau daftarkan akun baru Anda untuk mulai mengoleksi buku terbaik dengan mudah.</p>
            <a href="login.php" class="btn btn-light text-primary btn-sm fw-bold">Masuk Sekarang</a>
            <a href="register.php" class="btn btn-outline-light btn-sm fw-bold ms-2">Daftar Gratis</a>
        </div>
    </div>
<?php endif; ?> -->


<!-- Hero Section -->
<section class="position-relative text-white text-center rounded-3 mb-5 overflow-hidden shadow"
    style="min-height: 400px; display: flex; align-items: center; justify-content: center; background: url('assets/img/hero-bg.jpg') center/cover no-repeat;">

    <!-- Dark Overlay untuk kontras teks -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.75;"></div>

    <!-- Hero Content -->
    <div class="position-relative z-1 p-4 px-md-5 w-100" style="max-width: 800px;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <h1 class="display-4 fw-bold mb-3">Hai, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
            <p class="lead mb-4 opacity-90">Selamat datang kembali di Book Store Center. Temukan dan dapatkan koleksi buku impian Anda sekarang!</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="#katalog" class="btn btn-primary btn-lg fw-bold px-4 shadow-sm">Mulai Belanja</a>
                <a href="riwayat.php" class="btn btn-outline-light btn-lg fw-bold px-4 shadow-sm">Pesanan Anda</a>
            </div>
        <?php else: ?>
            <h1 class="display-4 fw-bold mb-3">Selamat Datang di Book Store Center!</h1>
            <p class="lead mb-4 opacity-90">Jelajahi ribuan koleksi buku terbaik. Masuk atau daftarkan akun baru Anda untuk mulai mengoleksi dengan mudah.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="login.php" class="btn btn-primary btn-lg fw-bold px-4 shadow-sm">Masuk Sekarang</a>
                <a href="register.php" class="btn btn-outline-light btn-lg fw-bold px-4 shadow-sm">Daftar Gratis</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Tambahkan id="katalog" agar tombol 'Mulai Belanja' bisa melakukan scroll ke sini -->
<div id="katalog" class="pt-3 mb-4">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <h2 class="mb-0">Katalog Buku</h2>
        </div>
        <div class="col-md-6">
            <!-- Form Pencarian -->
            <form action="index.php" method="GET" class="d-flex">
                <?php if (isset($_GET['kategori']) && $_GET['kategori'] != ''): ?>
                    <input type="hidden" name="kategori" value="<?= htmlspecialchars($_GET['kategori']) ?>">
                <?php endif; ?>
                <input type="text" name="cari" class="form-control me-2" placeholder="Cari judul atau penulis..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                <?php if (isset($_GET['cari']) || isset($_GET['kategori'])): ?>
                    <a href="index.php" class="btn btn-outline-danger ms-2">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="d-flex flex-nowrap overflow-auto mb-4 pb-2" style="-webkit-overflow-scrolling: touch;">
        <?php 
            $all_active = (!isset($_GET['kategori']) || $_GET['kategori'] == '') ? 'btn-primary' : 'btn-outline-primary';
            $url_all = "index.php" . (isset($_GET['cari']) && $_GET['cari'] != '' ? "?cari=".urlencode($_GET['cari']) : "");
        ?>
        <a href="<?= $url_all ?>" class="btn <?= $all_active ?> rounded-pill px-4 flex-shrink-0 me-2 shadow-sm">Semua</a>
        
        <?php while ($kat = mysqli_fetch_assoc($result_kat)): ?>
            <?php 
                $kat_active = (isset($_GET['kategori']) && $_GET['kategori'] == $kat['id']) ? 'btn-primary' : 'btn-outline-primary';
                $url_kat = "index.php?kategori=" . $kat['id'] . (isset($_GET['cari']) && $_GET['cari'] != '' ? "&cari=".urlencode($_GET['cari']) : "");
            ?>
            <a href="<?= $url_kat ?>" class="btn <?= $kat_active ?> rounded-pill px-3 flex-shrink-0 me-2 shadow-sm"><?= htmlspecialchars($kat['name']) ?></a>
        <?php endwhile; ?>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-md-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($book = mysqli_fetch_assoc($result)): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                        <!-- Cek ketersediaan cover buku -->
                        <?php
                        $cover = !empty($book['cover_image']) ? "assets/img/covers/" . $book['cover_image'] : "https://via.placeholder.com/300x400?text=No+Cover";
                        ?>
                        <div class="position-relative">
                            <img src="<?= $cover ?>" class="card-img-top w-100" alt="<?= htmlspecialchars($book['title']) ?>" style="height: 280px; object-fit: cover;">
                            <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2 px-2 py-1" style="font-size: 0.7rem;">
                                <?= htmlspecialchars($book['category_name'] ?? 'Umum') ?>
                            </span>
                        </div>

                        <div class="card-body p-2 p-md-3 d-flex flex-column">
                            <h6 class="card-title text-truncate fw-bold mb-1" title="<?= htmlspecialchars($book['title']) ?>" style="font-size: 0.95rem;">
                                <?= htmlspecialchars($book['title']) ?>
                            </h6>
                            <p class="card-text text-muted mb-2 text-truncate" style="font-size: 0.8rem;"><i class="bi bi-person me-1"></i><?= htmlspecialchars($book['author']) ?></p>
                            <h6 class="text-primary fw-bold mt-auto mb-0" style="font-size: 1rem;">Rp <?= number_format($book['price'], 0, ',', '.') ?></h6>
                        </div>

                        <div class="card-footer bg-white border-top-0 d-grid gap-2">
                            <a href="detail.php?id=<?= $book['id'] ?>" class="btn btn-outline-primary btn-sm">Lihat Detail</a>

                            <!-- Form untuk menambah ke keranjang -->
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn btn-primary btn-sm w-100" <?= $book['stock'] <= 0 ? 'disabled' : '' ?>>
                                    <?= $book['stock'] <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Buku tidak ditemukan.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
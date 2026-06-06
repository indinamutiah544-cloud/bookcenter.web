<?php
// Letakkan logic di atas
require_once 'config/koneksi.php';

// Validasi ID (pastikan integer untuk mencegah SQL Injection basic)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id == 0) {
    header("Location: index.php");
    exit;
}

// Ambil data buku + kategori
$query = "SELECT books.*, categories.name AS category_name 
          FROM books 
          LEFT JOIN categories ON books.category_id = categories.id 
          WHERE books.id = $id";
$result = mysqli_query($koneksi, $query);

// Jika buku tidak ditemukan, kembalikan ke index
if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit;
}

$book = mysqli_fetch_assoc($result);

// Baru panggil UI
require_once 'includes/header.php';
?>

<div class="row mt-4">
    <!-- Kolom Gambar -->
    <div class="col-md-4 mb-4 text-center">
        <?php $cover = !empty($book['cover_image']) ? "assets/img/covers/" . $book['cover_image'] : "https://via.placeholder.com/400x600?text=No+Cover"; ?>
        <img src="<?= $cover ?>" class="img-fluid rounded shadow-sm w-75 w-md-100" alt="<?= htmlspecialchars($book['title']) ?>">
    </div>

    <!-- Kolom Detail -->
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($book['category_name'] ?? 'Kategori') ?></li>
            </ol>
        </nav>

        <h2 class="fw-bold"><?= htmlspecialchars($book['title']) ?></h2>
        <p class="text-muted fs-5 mb-2">Karya: <?= htmlspecialchars($book['author']) ?> | Penerbit: <?= htmlspecialchars($book['publisher'] ?? '-') ?></p>
        
        <h3 class="text-primary fw-bold my-3">Rp <?= number_format($book['price'], 0, ',', '.') ?></h3>
        
        <p class="mb-2"><strong>Stok Tersedia:</strong> <?= $book['stock'] ?> Buku</p>
        
        <h5 class="mt-4">Deskripsi Buku</h5>
        <hr class="mb-3">
        <p style="white-space: pre-line; text-align: justify; font-size: 0.95rem;">
            <?= htmlspecialchars($book['description']) ?>
        </p>

        <!-- Tombol Aksi -->
        <div class="mt-4 mb-5 d-flex flex-column flex-sm-row gap-2">
            <form action="cart.php" method="POST" class="w-100">
                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" <?= $book['stock'] <= 0 ? 'disabled' : '' ?>>
                    <i class="bi bi-cart-plus me-1"></i> <?= $book['stock'] <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' ?>
                </button>
            </form>
            <a href="index.php" class="btn btn-outline-secondary btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center">
                Kembali
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
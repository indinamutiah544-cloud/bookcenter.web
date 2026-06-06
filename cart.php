<?php
require_once 'config/koneksi.php';
session_start();

// Wajib login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- 1. LOGIK PROSES (TAMBAH / HAPUS) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $book_id = (int)$_POST['book_id'];

    // Cek stok buku saat ini
    $cek_buku = mysqli_query($koneksi, "SELECT stock FROM books WHERE id = $book_id");
    $buku = mysqli_fetch_assoc($cek_buku);
    $stok_buku = $buku['stock'];

    // Cek apakah buku sudah ada di keranjang user ini
    $cek_query = "SELECT id, quantity FROM carts WHERE user_id = $user_id AND book_id = $book_id";
    $cek_result = mysqli_query($koneksi, $cek_query);

    if (mysqli_num_rows($cek_result) > 0) {
        // Jika ada, update quantity + 1
        $row = mysqli_fetch_assoc($cek_result);
        $new_qty = $row['quantity'] + 1;
        
        if ($new_qty <= $stok_buku) {
            mysqli_query($koneksi, "UPDATE carts SET quantity = $new_qty WHERE id = " . $row['id']);
        } else {
            header("Location: cart.php?pesan=stok_habis");
            exit;
        }
    } else {
        // Jika belum ada, insert baru
        if ($stok_buku >= 1) {
            mysqli_query($koneksi, "INSERT INTO carts (user_id, book_id, quantity) VALUES ($user_id, $book_id, 1)");
        } else {
            header("Location: cart.php?pesan=stok_habis");
            exit;
        }
    }
    
    // Redirect ke keranjang agar tidak duplicate submit saat di-refresh (PRG Pattern)
    header("Location: cart.php");
    exit;
}

// Aksi hapus item keranjang
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $cart_id = (int)$_GET['id'];
    // Pastikan user hanya bisa menghapus keranjangnya sendiri
    mysqli_query($koneksi, "DELETE FROM carts WHERE id = $cart_id AND user_id = $user_id");
    header("Location: cart.php");
    exit;
}


// --- 2. LOGIK TAMPILKAN DATA ---
$query_cart = "SELECT c.id AS cart_id, c.quantity, b.id AS book_id, b.title, b.price, b.stock, b.cover_image 
               FROM carts c 
               JOIN books b ON c.book_id = b.id 
               WHERE c.user_id = $user_id";
$result_cart = mysqli_query($koneksi, $query_cart);
$total_belanja = 0;

// Baru panggil UI
require_once 'includes/header.php';
?>

<div class="row mt-4">
    <div class="col-12">
        <h2 class="mb-4">Keranjang Belanja</h2>
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'stok_habis'): ?>
            <div class="alert alert-danger">Gagal menambahkan ke keranjang: Stok buku tidak mencukupi.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Buku</th>
                                <th>Harga</th>
                                <th width="100">Jumlah</th>
                                <th>Subtotal</th>
                                <th class="pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result_cart) > 0): ?>
                                <?php while ($item = mysqli_fetch_assoc($result_cart)): ?>
                                    <?php 
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total_belanja += $subtotal;
                                    ?>
                                    <tr>
                                        <td class="ps-3">
                                            <h6 class="mb-0 text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($item['title']) ?>">
                                                <?= htmlspecialchars($item['title']) ?>
                                            </h6>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td class="fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                        <td class="pe-3">
                                            <a href="cart.php?action=hapus&id=<?= $item['cart_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus buku ini dari keranjang?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Keranjang Anda masih kosong. <a href="index.php">Belanja sekarang</a>.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Belanja -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ringkasan Belanja</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fs-5">Total Harga:</span>
                    <span class="fs-5 fw-bold text-primary">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
                </div>
                <hr>
                <?php if ($total_belanja > 0): ?>
                    <a href="checkout.php" class="btn btn-success w-100 btn-lg">Lanjut ke Checkout</a>
                <?php else: ?>
                    <button class="btn btn-secondary w-100 btn-lg" disabled>Checkout</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
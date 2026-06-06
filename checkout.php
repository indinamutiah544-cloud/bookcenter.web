<?php
require_once 'config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- PROSES CHECKOUT ---
if (isset($_POST['proses_checkout'])) {
    $shipping_address = mysqli_real_escape_string($koneksi, $_POST['shipping_address']);
    
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);
    
    try {
        $query_cart = "SELECT c.quantity, b.id AS book_id, b.price, b.stock, b.title 
                       FROM carts c JOIN books b ON c.book_id = b.id 
                       WHERE c.user_id = $user_id";
        $result_cart = mysqli_query($koneksi, $query_cart);
        
        if (mysqli_num_rows($result_cart) == 0) {
            header("Location: index.php");
            exit;
        }

        $total_amount = 0;
        $cart_items = [];
        while ($row = mysqli_fetch_assoc($result_cart)) {
            // Cek stok sebelum memproses
            if ($row['stock'] < $row['quantity']) {
                throw new Exception("Stok buku '" . $row['title'] . "' tidak mencukupi. (Tersedia: " . $row['stock'] . ")");
            }
            $total_amount += ($row['price'] * $row['quantity']);
            $cart_items[] = $row; // Simpan ke array untuk di-looping saat insert order_details
        }

        // Generate Invoice Number (Format: INV-TahunBulanTanggal-Uniqid) mencegah duplikasi
        $invoice_number = "INV-" . date('Ymd') . "-" . strtoupper(substr(uniqid(), -5));

        // 1. Insert ke tabel orders
        $query_order = "INSERT INTO orders (invoice_number, user_id, total_amount, shipping_address, status) 
                        VALUES ('$invoice_number', $user_id, $total_amount, '$shipping_address', 'pending')";
        
        if (!mysqli_query($koneksi, $query_order)) {
            throw new Exception("Gagal membuat pesanan.");
        }
        
        $order_id = mysqli_insert_id($koneksi); // Ambil ID order yang baru saja diinsert

        // 2. Insert ke order_details
        foreach ($cart_items as $item) {
            $book_id = $item['book_id'];
            $qty = $item['quantity'];
            $price_now = $item['price'];

            // Insert detail (mengunci harga)
            $query_detail = "INSERT INTO order_details (order_id, book_id, quantity, price_at_purchase) 
                             VALUES ($order_id, $book_id, $qty, $price_now)";
            if (!mysqli_query($koneksi, $query_detail)) {
                throw new Exception("Gagal menyimpan detail pesanan.");
            }
            
            // Kurangi stok buku
            $query_update_stock = "UPDATE books SET stock = stock - $qty WHERE id = $book_id";
            if (!mysqli_query($koneksi, $query_update_stock)) {
                throw new Exception("Gagal memperbarui stok buku.");
            }
        }

        // 3. Kosongkan keranjang user
        if (!mysqli_query($koneksi, "DELETE FROM carts WHERE user_id = $user_id")) {
            throw new Exception("Gagal menghapus keranjang.");
        }

        // Jika semua sukses, commit
        mysqli_commit($koneksi);
        
        // Berhasil, lempar ke riwayat
        header("Location: riwayat.php?pesan=sukses");
        exit;
    } catch (Exception $e) {
        // Rollback semua perubahan jika terjadi error
        mysqli_rollback($koneksi);
        $pesan_error = urlencode($e->getMessage());
        header("Location: cart.php?error=" . $pesan_error);
        exit;
    }
}

// --- TAMPILAN FORM ---
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($query_user);

// Ambil total untuk ditampilkan saja
$query_total = mysqli_query($koneksi, "SELECT SUM(b.price * c.quantity) AS total FROM carts c JOIN books b ON c.book_id = b.id WHERE c.user_id = $user_id");
$total_data = mysqli_fetch_assoc($query_total);
$total_tampil = $total_data['total'] ?? 0;

if ($total_tampil == 0) {
    header("Location: index.php");
    exit;
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Checkout Pesanan</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Total yang harus dibayar: <strong>Rp <?= number_format($total_tampil, 0, ',', '.') ?></strong>
                </div>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['name']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['phone']) ?>" readonly>
                        <small class="text-muted">Untuk mengubah profil, silakan hubungi admin.</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Alamat Pengiriman Lengkap</label>
                        <textarea name="shipping_address" class="form-control" rows="4" required><?= htmlspecialchars($user_data['address']) ?></textarea>
                        <small class="text-muted">Pastikan alamat pengiriman sudah benar dan lengkap (Jalan, RT/RW, Kecamatan, Kota/Kab, Kode Pos).</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="proses_checkout" class="btn btn-success btn-lg" onclick="return confirm('Apakah data pengiriman sudah benar? Pesanan akan segera diproses.')">
                            Proses Pesanan Sekarang
                        </button>
                        <a href="cart.php" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
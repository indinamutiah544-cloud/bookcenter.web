<?php
require_once 'config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data order
$query_order = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$result_order = mysqli_query($koneksi, $query_order);

if (mysqli_num_rows($result_order) == 0) {
    header("Location: riwayat.php");
    exit;
}

$order = mysqli_fetch_assoc($result_order);

// Ambil data detail item
$query_details = "SELECT od.quantity, od.price_at_purchase, b.title 
                  FROM order_details od 
                  JOIN books b ON od.book_id = b.id 
                  WHERE od.order_id = $order_id";
$result_details = mysqli_query($koneksi, $query_details);

require_once 'includes/header.php';
?>

<div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Invoice</h5>
                <span><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-1 text-muted">Nomor Invoice:</h6>
                        <h4 class="fw-bold"><?= $order['invoice_number'] ?></h4>
                        
                        <h6 class="mt-3 mb-1 text-muted">Status Pesanan:</h6>
                        <h5>
                            <?php 
                                if ($order['status'] == 'pending') echo '<span class="badge bg-warning text-dark">Belum Bayar</span>';
                                elseif ($order['status'] == 'waiting_verification') echo '<span class="badge bg-info text-dark">Menunggu Validasi</span>';
                                elseif ($order['status'] == 'processing') echo '<span class="badge bg-primary">Diproses</span>';
                                elseif ($order['status'] == 'shipped') echo '<span class="badge bg-primary">Dikirim</span>';
                                elseif ($order['status'] == 'completed') echo '<span class="badge bg-success">Selesai</span>';
                                else echo '<span class="badge bg-danger">Dibatalkan</span>';
                            ?>
                        </h5>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="mb-1 text-muted">Alamat Pengiriman:</h6>
                        <p class="mb-0" style="white-space: pre-line;"><?= htmlspecialchars($order['shipping_address']) ?></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Buku</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = mysqli_fetch_assoc($result_details)): ?>
                                <?php $subtotal = $item['price_at_purchase'] * $item['quantity']; ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['title']) ?></td>
                                    <td class="text-center">Rp <?= number_format($item['price_at_purchase'], 0, ',', '.') ?></td>
                                    <td class="text-center"><?= $item['quantity'] ?></td>
                                    <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Pembayaran:</th>
                                <th class="text-end text-primary fs-5">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <?php if ($order['status'] == 'pending'): ?>
                        <a href="upload_bayar.php?id=<?= $order['id'] ?>" class="btn btn-success">Upload Bukti Pembayaran</a>
                    <?php endif; ?>
                    <a href="riwayat.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
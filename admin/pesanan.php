<?php
require_once '../config/koneksi.php';
require_once 'includes/header.php';

$pesan = '';

// --- 1. LOGIK UPDATE STATUS PESANAN ---
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status_baru = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query_update = "UPDATE orders SET status = '$status_baru' WHERE id = $order_id";
    if (mysqli_query($koneksi, $query_update)) {
        $pesan = "<div class='alert alert-success'>Status pesanan berhasil diperbarui!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Gagal memperbarui status.</div>";
    }
}

// --- 2. AMBIL DATA PESANAN ---
// Join dengan tabel users untuk mendapat nama pembeli
$query = "SELECT o.*, u.name AS customer_name 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          ORDER BY o.id DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="row mb-3">
    <div class="col-12">
        <h2 class="mb-0">Manajemen Pesanan</h2>
        <p class="text-muted">Kelola status pesanan dan validasi bukti pembayaran.</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?= $pesan ?>
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Invoice</th>
                                <th>Pelanggan</th>
                                <th>Total Tagihan</th>
                                <th>Bukti Bayar</th>
                                <th class="pe-3">Status & Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge bg-secondary"><?= $order['invoice_number'] ?></span><br>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></small>
                                    </td>
                                    <td class="fw-bold"><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td class="text-primary fw-bold">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if (!empty($order['payment_proof'])): ?>
                                            <a href="../assets/img/proofs/<?= htmlspecialchars($order['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-info">Lihat Bukti</a>
                                        <?php else: ?>
                                            <span class="text-muted small">Belum ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-3">
                                        <?php 
                                            // Form ganti status khusus admin
                                        ?>
                                        <form action="" method="POST" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="waiting_verification" <?= $order['status'] == 'waiting_verification' ? 'selected' : '' ?>>Verifikasi</option>
                                                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Diproses</option>
                                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Dikirim</option>
                                                <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Selesai</option>
                                                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Batal</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data pesanan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                        </div>

<?php require_once 'includes/footer.php'; ?>
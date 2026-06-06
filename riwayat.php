<?php
require_once 'config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat order user
$query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

require_once 'includes/header.php';
?>

<div class="row mt-4">
    <div class="col-12">
        <h2 class="mb-4">Riwayat Pesanan</h2>
        
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Pesanan Berhasil Dibuat!</strong> Silakan upload bukti pembayaran agar pesanan dapat diproses.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th>No. Invoice</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th class="pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td class="ps-3"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                                        <td><span class="badge bg-secondary"><?= $order['invoice_number'] ?></span></td>
                                        <td class="fw-bold text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php 
                                                // Badge warna berdasarkan status
                                                if ($order['status'] == 'pending') echo '<span class="badge bg-warning text-dark">Belum Bayar</span>';
                                                elseif ($order['status'] == 'waiting_verification') echo '<span class="badge bg-info text-dark">Menunggu Validasi</span>';
                                                elseif ($order['status'] == 'processing') echo '<span class="badge bg-primary">Diproses</span>';
                                                elseif ($order['status'] == 'shipped') echo '<span class="badge bg-primary">Dikirim</span>';
                                                elseif ($order['status'] == 'completed') echo '<span class="badge bg-success">Selesai</span>';
                                                else echo '<span class="badge bg-danger">Dibatalkan</span>';
                                            ?>
                                        </td>
                                        <td class="pe-3">
                                            <!-- Tombol Detail (Nanti diarahkan ke halaman detail invoice) -->
                                            <a href="invoice.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                            
                                            <?php if ($order['status'] == 'pending'): ?>
                                                <!-- Fitur upload bayar bisa digabung di halaman invoice atau dibikin form terpisah -->
                                                <a href="upload_bayar.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-success">Upload Bukti</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat pesanan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
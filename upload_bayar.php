<?php
require_once 'config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Wajib login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pesan = '';

// Ambil data order untuk divalidasi
$query = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: riwayat.php");
    exit;
}

$order = mysqli_fetch_assoc($result);

// Pastikan hanya bisa upload jika statusnya masih pending
if ($order['status'] != 'pending') {
    header("Location: riwayat.php");
    exit;
}

// Proses Upload Gambar
if (isset($_POST['upload'])) {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $nama_file = $_FILES['bukti_bayar']['name'];
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['bukti_bayar']['size'];
    $file_tmp = $_FILES['bukti_bayar']['tmp_name'];

    // Rename file biar unik (mencegah file tertimpa jika nama sama)
    $nama_file_baru = 'proof_' . $order['invoice_number'] . '_' . time() . '.' . $ekstensi;

    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran < 2048000) { // Maksimal 2MB
            // Pastikan folder tujuan ada
            $target_dir = 'assets/img/proofs/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            // Pindahkan file ke folder tujuan
            move_uploaded_file($file_tmp, $target_dir . $nama_file_baru);

            // Update database
            $query_update = "UPDATE orders SET payment_proof = '$nama_file_baru', status = 'waiting_verification' WHERE id = $order_id";
            if (mysqli_query($koneksi, $query_update)) {
                header("Location: riwayat.php?pesan=upload_sukses");
                exit;
            } else {
                $pesan = "<div class='alert alert-danger'>Gagal update database.</div>";
            }
        } else {
            $pesan = "<div class='alert alert-danger'>Ukuran file terlalu besar. Maksimal 2MB.</div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger'>Ekstensi file tidak diperbolehkan (Hanya JPG/PNG).</div>";
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <?= $pesan ?>
                <div class="alert alert-info">
                    Silakan transfer sebesar <strong>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong><br>
                    Ke Rekening <strong>BCA: 1234567890 (a.n Book Store Center)</strong><br>
                    No. Invoice: <strong><?= $order['invoice_number'] ?></strong>
                </div>

                <!-- Pastikan ada enctype="multipart/form-data" untuk form upload file -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Bukti Transfer (JPG/PNG)</label>
                        <input type="file" name="bukti_bayar" class="form-control" required accept="image/png, image/jpeg">
                        <small class="text-muted">Maksimal ukuran file: 2MB</small>
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary w-100">Upload Sekarang</button>
                    <a href="riwayat.php" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
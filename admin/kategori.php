<?php
require_once '../config/koneksi.php';
require_once 'includes/header.php';

$pesan = '';

// --- 1. LOGIK TAMBAH KATEGORI ---
if (isset($_POST['tambah_kategori'])) {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    // Generate slug sederhana (contoh: "Buku Religi" -> "buku-religi")
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    $query_cek = mysqli_query($koneksi, "SELECT id FROM categories WHERE slug = '$slug'");
    if (mysqli_num_rows($query_cek) > 0) {
        $pesan = "<div class='alert alert-danger'>Kategori '$name' sudah ada!</div>";
    } else {
        if (mysqli_query($koneksi, "INSERT INTO categories (name, slug) VALUES ('$name', '$slug')")) {
            header("Location: kategori.php?pesan=sukses");
            exit;
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal menambah kategori.</div>";
        }
    }
}

// --- 2. LOGIK HAPUS KATEGORI ---
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    
    // Cek apakah kategori sedang dipakai di tabel books
    $cek_buku = mysqli_query($koneksi, "SELECT id FROM books WHERE category_id = $id_hapus");
    if (mysqli_num_rows($cek_buku) > 0) {
        $pesan = "<div class='alert alert-warning'>Tidak dapat menghapus! Kategori ini sedang digunakan oleh beberapa buku.</div>";
    } else {
        mysqli_query($koneksi, "DELETE FROM categories WHERE id = $id_hapus");
        header("Location: kategori.php?pesan=hapus_sukses");
        exit;
    }
}

// Menangkap pesan sukses dari URL (PRG pattern)
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'sukses') $pesan = "<div class='alert alert-success'>Kategori berhasil ditambahkan!</div>";
    if ($_GET['pesan'] == 'hapus_sukses') $pesan = "<div class='alert alert-success'>Kategori berhasil dihapus!</div>";
}

// --- 3. AMBIL DATA KATEGORI ---
$result = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Kategori</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Novel Fiksi">
                    </div>
                    <button type="submit" name="tambah_kategori" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <?= $pesan ?>
        <div class="card shadow-sm">
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50" class="ps-3">No</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th width="100" class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['name']) ?></td>
                                <td class="text-muted"><?= htmlspecialchars($row['slug']) ?></td>
                                <td class="text-center pe-3">
                                    <a href="kategori.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if(mysqli_num_rows($result) == 0): ?>
                            <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada kategori.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

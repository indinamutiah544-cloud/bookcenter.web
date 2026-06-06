<?php
require_once '../config/koneksi.php';
require_once 'includes/header.php';

$pesan = '';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// --- LOGIK HAPUS BUKU ---
if ($action == 'hapus' && isset($_GET['id'])) {
    $id_hapus = (int)$_GET['id'];
    
    // Cek apakah buku sudah pernah dibeli (ada di tabel order_details)
    // Berdasarkan desain database kita, buku yang sudah dibeli tidak bisa dihapus (ON DELETE RESTRICT)
    $cek_order = mysqli_query($koneksi, "SELECT id FROM order_details WHERE book_id = $id_hapus");
    
    if (mysqli_num_rows($cek_order) > 0) {
        $pesan = "<div class='alert alert-danger'>Gagal! Buku ini sudah memiliki riwayat transaksi. Solusi: Ubah stok menjadi 0.</div>";
        $action = 'list';
    } else {
        // Hapus file gambar cover dulu
        $query_buku = mysqli_query($koneksi, "SELECT cover_image FROM books WHERE id = $id_hapus");
        $data_buku = mysqli_fetch_assoc($query_buku);
        if ($data_buku['cover_image'] != '' && file_exists('../assets/img/covers/' . $data_buku['cover_image'])) {
            unlink('../assets/img/covers/' . $data_buku['cover_image']);
        }
        
        // Hapus dari database
        mysqli_query($koneksi, "DELETE FROM books WHERE id = $id_hapus");
        header("Location: buku.php?pesan=hapus_sukses");
        exit;
    }
}

// --- LOGIK PROSES TAMBAH BUKU ---
if (isset($_POST['simpan_buku'])) {
    $title       = mysqli_real_escape_string($koneksi, $_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $author      = mysqli_real_escape_string($koneksi, $_POST['author']);
    $publisher   = mysqli_real_escape_string($koneksi, $_POST['publisher']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $price       = (int)$_POST['price'];
    $stock       = (int)$_POST['stock'];
    
    $nama_file_baru = "";
    
    // Proses Upload Cover
    if ($_FILES['cover']['name'] != '') {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $nama_file = $_FILES['cover']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['cover']['tmp_name'];
        
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $nama_file_baru = 'cover_' . time() . '.' . $ekstensi;
            $target_dir = '../assets/img/covers/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            move_uploaded_file($file_tmp, $target_dir . $nama_file_baru);
        } else {
            $pesan = "<div class='alert alert-danger'>Ekstensi gambar tidak diperbolehkan.</div>";
        }
    }

    $query_insert = "INSERT INTO books (category_id, title, author, publisher, description, price, stock, cover_image) 
                     VALUES ($category_id, '$title', '$author', '$publisher', '$description', $price, $stock, '$nama_file_baru')";
                     
    if (mysqli_query($koneksi, $query_insert)) {
        header("Location: buku.php?pesan=tambah_sukses");
        exit;
    }
}

// --- LOGIK PROSES EDIT BUKU ---
if (isset($_POST['update_buku'])) {
    $id          = (int)$_POST['id'];
    $title       = mysqli_real_escape_string($koneksi, $_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $author      = mysqli_real_escape_string($koneksi, $_POST['author']);
    $publisher   = mysqli_real_escape_string($koneksi, $_POST['publisher']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $price       = (int)$_POST['price'];
    $stock       = (int)$_POST['stock'];
    
    // Ambil data cover lama
    $query_buku_lama = mysqli_query($koneksi, "SELECT cover_image FROM books WHERE id = $id");
    $data_buku_lama = mysqli_fetch_assoc($query_buku_lama);
    $nama_file_baru = $data_buku_lama['cover_image'];
    
    // Proses Upload Cover jika ada yang baru
    if ($_FILES['cover']['name'] != '') {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $nama_file = $_FILES['cover']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['cover']['tmp_name'];
        
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $nama_file_baru = 'cover_' . time() . '.' . $ekstensi;
            $target_dir = '../assets/img/covers/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            move_uploaded_file($file_tmp, $target_dir . $nama_file_baru);
            // Hapus cover lama jika ada
            if ($data_buku_lama['cover_image'] != '' && file_exists('../assets/img/covers/' . $data_buku_lama['cover_image'])) {
                unlink('../assets/img/covers/' . $data_buku_lama['cover_image']);
            }
        } else {
            $pesan = "<div class='alert alert-danger'>Ekstensi gambar tidak diperbolehkan.</div>";
        }
    }

    $query_update = "UPDATE books SET 
                        category_id = $category_id, 
                        title = '$title', 
                        author = '$author', 
                        publisher = '$publisher', 
                        description = '$description', 
                        price = $price, 
                        stock = $stock, 
                        cover_image = '$nama_file_baru' 
                     WHERE id = $id";
                     
    if (mysqli_query($koneksi, $query_update)) {
        header("Location: buku.php?pesan=edit_sukses");
        exit;
    }
}

// Tangkap Notifikasi
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'tambah_sukses') $pesan = "<div class='alert alert-success'>Buku berhasil ditambahkan!</div>";
    if ($_GET['pesan'] == 'hapus_sukses') $pesan = "<div class='alert alert-success'>Buku berhasil dihapus!</div>";
    if ($_GET['pesan'] == 'edit_sukses') $pesan = "<div class='alert alert-success'>Buku berhasil diperbarui!</div>";
}
?>

<!-- ========================================================
     TAMPILAN BERDASARKAN ACTION (TAMBAH / LIST)
========================================================= -->

<?php if ($action == 'tambah'): ?>
<!-- TAMPILAN FORM TAMBAH BUKU -->
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Buku Baru</h5>
                <a href="buku.php" class="btn btn-sm btn-light">Kembali</a>
            </div>
            <div class="card-body">
                <?= $pesan ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                    $kat = mysqli_query($koneksi, "SELECT * FROM categories");
                                    while ($k = mysqli_fetch_assoc($kat)) {
                                        echo "<option value='{$k['id']}'>{$k['name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Penulis</label>
                            <input type="text" name="author" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Penerbit</label>
                            <input type="text" name="publisher" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi Buku</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-4">
                        <label>Upload Cover Gambar (JPG/PNG)</label>
                        <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg">
                    </div>
                    <button type="submit" name="simpan_buku" class="btn btn-primary btn-lg w-100">Simpan Buku</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php elseif ($action == 'edit' && isset($_GET['id'])): 
    $id_edit = (int)$_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM books WHERE id = $id_edit");
    if(mysqli_num_rows($query_edit) == 0) {
        header("Location: buku.php");
        exit;
    }
    $buku_edit = mysqli_fetch_assoc($query_edit);
?>
<!-- TAMPILAN FORM EDIT BUKU -->
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Buku</h5>
                <a href="buku.php" class="btn btn-sm btn-light">Kembali</a>
            </div>
            <div class="card-body">
                <?= $pesan ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $buku_edit['id'] ?>">
                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($buku_edit['title']) ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                    $kat = mysqli_query($koneksi, "SELECT * FROM categories");
                                    while ($k = mysqli_fetch_assoc($kat)) {
                                        $selected = ($k['id'] == $buku_edit['category_id']) ? 'selected' : '';
                                        echo "<option value='{$k['id']}' $selected>{$k['name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Penulis</label>
                            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($buku_edit['author']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Penerbit</label>
                            <input type="text" name="publisher" class="form-control" value="<?= htmlspecialchars($buku_edit['publisher']) ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="<?= $buku_edit['price'] ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" value="<?= $buku_edit['stock'] ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi Buku</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($buku_edit['description']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label>Upload Cover Gambar (JPG/PNG) - Biarkan kosong jika tidak diganti</label>
                        <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg">
                        <?php if(!empty($buku_edit['cover_image'])): ?>
                            <small class="text-muted d-block mt-2">Cover saat ini: <?= $buku_edit['cover_image'] ?></small>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="update_buku" class="btn btn-warning btn-lg w-100">Update Buku</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- TAMPILAN TABEL DAFTAR BUKU -->
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Manajemen Buku</h2>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="buku.php?action=tambah" class="btn btn-primary">+ Tambah Buku Baru</a>
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
                                <th width="80" class="ps-3">Cover</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                                <th width="150" class="text-center pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = "SELECT b.*, c.name as category_name FROM books b JOIN categories c ON b.category_id = c.id ORDER BY b.id DESC";
                            $result = mysqli_query($koneksi, $query);
                            if (mysqli_num_rows($result) > 0): 
                                while ($row = mysqli_fetch_assoc($result)): 
                                    $cover = !empty($row['cover_image']) ? "../assets/img/covers/" . $row['cover_image'] : "https://via.placeholder.com/50x75?text=No+Cover";
                            ?>
                                <tr>
                                    <td class="ps-3"><img src="<?= $cover ?>" alt="cover" class="img-thumbnail" style="width: 50px; height: 75px; object-fit: cover;"></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($row['author']) ?></small>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['category_name']) ?></span></td>
                                    <td class="text-primary fw-bold">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <?= $row['stock'] > 0 ? $row['stock'] : "<span class='badge bg-danger'>Habis</span>" ?>
                                    </td>
                                    <td class="text-center pe-3">
                                        <a href="buku.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="buku.php?action=hapus&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data buku.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
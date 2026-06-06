<?php
session_start();
require_once '../config/koneksi.php';

// Cek jika belum login atau bukan admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Menangani Aksi
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];

    // Mencegah admin mengubah status/role dirinya sendiri
    if ($id == $_SESSION['user_id']) {
        $_SESSION['flash_msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Anda tidak bisa mengubah status/akun Anda sendiri!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        header("Location: users.php");
        exit;
    }

    if ($action == 'toggle_role') {
        $q = mysqli_query($koneksi, "SELECT role FROM users WHERE id = $id");
        $user = mysqli_fetch_assoc($q);
        if ($user) {
            $new_role = ($user['role'] == 'admin') ? 'user' : 'admin';
            mysqli_query($koneksi, "UPDATE users SET role = '$new_role' WHERE id = $id");
            $msg = ($new_role == 'admin') ? 'berhasil dijadikan Admin' : 'dikembalikan menjadi User';
            $_SESSION['flash_msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Akun $msg!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    } elseif ($action == 'toggle_suspend') {
        $q = mysqli_query($koneksi, "SELECT is_suspended FROM users WHERE id = $id");
        $user = mysqli_fetch_assoc($q);
        if ($user) {
            $new_status = ($user['is_suspended'] == 1) ? 0 : 1;
            mysqli_query($koneksi, "UPDATE users SET is_suspended = $new_status WHERE id = $id");
            $msg = ($new_status == 1) ? 'ditangguhkan sementara' : 'dibuka dari penangguhan';
            $_SESSION['flash_msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Akun berhasil $msg!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    } elseif ($action == 'delete') {
        if (mysqli_query($koneksi, "DELETE FROM users WHERE id = $id")) {
            $_SESSION['flash_msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Akun berhasil dihapus permanen!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {
            $_SESSION['flash_msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Gagal menghapus akun. Mungkin akun memiliki pesanan/data terkait.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    }

    header("Location: users.php");
    exit;
}

// Ambil data users
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$query_users = "SELECT * FROM users ";
if ($search != '') {
    $query_users .= "WHERE name LIKE '%$search%' OR email LIKE '%$search%' ";
}
$query_users .= "ORDER BY id DESC";
$users = mysqli_query($koneksi, $query_users);

require_once 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6">
        <h3 class="mb-0">Kelola Pengguna</h3>
        <p class="text-muted">Kelola peran dan status akun pengguna</p>
    </div>
    <div class="col-md-6">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            <?php if($search): ?>
                <a href="users.php" class="btn btn-secondary ms-2"><i class="bi bi-x-lg"></i></a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php 
if (isset($_SESSION['flash_msg'])) {
    echo $_SESSION['flash_msg'];
    unset($_SESSION['flash_msg']);
}
?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($users) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($users)): ?>
                            <tr>
                                <td class="ps-4 fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <?php if ($row['role'] == 'admin'): ?>
                                        <span class="badge bg-primary">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">User</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['is_suspended'] == 1): ?>
                                        <span class="badge bg-danger">Ditangguhkan</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pe-4">
                                    <?php if ($row['id'] != $_SESSION['user_id']): ?>
                                        <!-- Toggle Role -->
                                        <?php if ($row['role'] == 'admin'): ?>
                                            <a href="users.php?action=toggle_role&id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Jadikan User" onclick="return confirm('Turunkan jabatan ke User?')">
                                                <i class="bi bi-person-down"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="users.php?action=toggle_role&id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Jadikan Admin" onclick="return confirm('Angkat menjadi Admin?')">
                                                <i class="bi bi-person-up"></i>
                                            </a>
                                        <?php endif; ?>

                                        <!-- Toggle Suspend -->
                                        <?php if ($row['is_suspended'] == 1): ?>
                                            <a href="users.php?action=toggle_suspend&id=<?= $row['id'] ?>" class="btn btn-sm btn-success mx-1" title="Buka Penangguhan" onclick="return confirm('Buka penangguhan untuk akun ini?')">
                                                <i class="bi bi-unlock"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="users.php?action=toggle_suspend&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mx-1 text-dark" title="Tangguhkan Akun" onclick="return confirm('Tangguhkan sementara akun ini? Mereka tidak akan bisa login.')">
                                                <i class="bi bi-ban"></i>
                                            </a>
                                        <?php endif; ?>

                                        <!-- Delete -->
                                        <a href="users.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" title="Hapus Permanen" onclick="return confirm('Hapus permanen akun ini? Data akan hilang selamanya!')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small"><em>Akun Anda</em></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<?php
require_once 'config/koneksi.php';
require_once 'includes/header.php';

$pesan = '';

// Proses form jika disubmit
if (isset($_POST['register'])) {
    $name     = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $phone    = mysqli_real_escape_string($koneksi, $_POST['phone']);
    $address  = mysqli_real_escape_string($koneksi, $_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input kosong (Backend Validation)
    if (empty(trim($name)) || empty(trim($email)) || empty(trim($password))) {
        $pesan = "<div class='alert alert-danger'>Nama, Email, dan Password wajib diisi!</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = "<div class='alert alert-danger'>Format email tidak valid!</div>";
    } elseif ($password !== $confirm_password) {
        $pesan = "<div class='alert alert-danger'>Password dan konfirmasi password tidak cocok!</div>";
    } else {
        // Cek apakah email sudah terdaftar
        $cek_email = mysqli_query($koneksi, "SELECT email FROM users WHERE email = '$email'");

        if (mysqli_num_rows($cek_email) > 0) {
            $pesan = "<div class='alert alert-danger'>Email sudah terdaftar. Silakan gunakan email lain!</div>";
        } else {
            // Hash password sebelum disimpan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Default role untuk register di public adalah 'user'
            $query = "INSERT INTO users (name, email, password, role, phone, address) 
                  VALUES ('$name', '$email', '$hashed_password', 'user', '$phone', '$address')";

            if (mysqli_query($koneksi, $query)) {
                $pesan = "<div class='alert alert-success'>Registrasi berhasil! Silakan <a href='login.php'>Login di sini</a>.</div>";
                echo "<script>setTimeout(() => { window.location.href = 'login.php'; }, 3000);</script>";
            } else {
                $pesan = "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
            }
        }
    }
}
?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-7">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-plus-fill fs-1"></i>
                    </div>
                    <h3 class="fw-bold">Buat Akun Baru</h3>
                    <p class="text-muted">Bergabunglah dengan Book Store Center sekarang.</p>
                </div>
                
                <?= $pesan ?>
                
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-1" placeholder="Nama lengkap Anda" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 ps-1" placeholder="Email aktif" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">No. HP</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="bi bi-telephone text-muted"></i></span>
                            <input type="text" name="phone" class="form-control border-start-0 ps-1" placeholder="Nomor WhatsApp/HP">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent align-items-start pt-2"><i class="bi bi-geo-alt text-muted"></i></span>
                            <textarea name="address" class="form-control border-start-0 ps-1" rows="3" placeholder="Alamat pengiriman buku"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 ps-1" placeholder="Buat password" required>
                                <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button" data-target="#password">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control border-start-0 border-end-0 ps-1" placeholder="Ulangi password" required>
                                <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button" data-target="#confirm_password">
                                    <i class="bi bi-eye-slash text-muted"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-primary w-100 py-3 fw-bold fs-5 rounded-3 mb-3 shadow-sm">Daftar Sekarang</button>
                </form>
                
                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted mb-0">Sudah punya akun? <a href="login.php" class="text-primary fw-semibold text-decoration-none">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
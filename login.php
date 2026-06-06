<?php
// Letakkan logic PHP di atas agar header() redirect tidak error "headers already sent"
require_once 'config/koneksi.php';
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

// Jika sudah login, lempar ke halaman yang sesuai
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$pesan = '';

// Proses form login
if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi kecocokan hash password
        if (password_verify($password, $user['password'])) {
            // Cek jika akun ditangguhkan
            if ($user['is_suspended'] == 1) {
                $pesan = "<div class='alert alert-warning'>Akun Anda sedang ditangguhkan. Silakan hubungi Admin.</div>";
            } else {
                // Set data session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name']    = $user['name'];
                $_SESSION['role']    = $user['role'];

                // Redirect berdasarkan role
                if ($user['role'] == 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        } else {
            $pesan = "<div class='alert alert-danger'>Password yang Anda masukkan salah!</div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger'>Email tidak ditemukan!</div>";
    }
}

// Baru panggil header HTML setelah semua logic redirect selesai
require_once 'includes/header.php';
?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-circle fs-1"></i>
                    </div>
                    <h3 class="fw-bold">Selamat Datang!</h3>
                    <p class="text-muted">Silakan masuk ke akun Book Store Anda.</p>
                </div>
                
                <?= $pesan ?>
                
                <form action="" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-1 " placeholder="Masukkan email Anda" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 ps-1" placeholder="Masukkan password Anda" required>
                            <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button" data-target="#password">
                                <i class="bi bi-eye-slash text-muted"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 py-3 fw-bold rounded-3 mb-3 shadow-sm">Masuk Sekarang</button>
                </form>
                
                <div class="text-center mt-4 pt-3 border-top">
                    <p class="text-muted mb-0">Belum punya akun? <a href="register.php" class="text-primary fw-semibold text-decoration-none">Daftar di sini</a></p>
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
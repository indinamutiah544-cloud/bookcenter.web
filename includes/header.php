<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
} 
// Dapatkan nama file saat ini untuk penanda active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store Center</title>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/darkmode.css">
    <style>
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link {
            font-weight: 500;
        }
        .user-greeting {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-xl navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center text-nowrap" href="index.php">
            <i class="bi bi-book-half me-2"></i> Book Store Center
        </a>
        
        <!-- Mobile Toggle Area -->
        <div class="d-flex align-items-center d-xl-none">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="#" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#profileModal" aria-label="Profile">
                    <i class="bi bi-person-circle"></i>
                </a>
            <?php endif; ?>
            <button class="btn btn-outline-light btn-sm dark-mode-toggle me-2" type="button" aria-label="Toggle Dark Mode">
                <i class="bi bi-moon-fill"></i>
            </button>
            <button class="navbar-toggler border-0 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'cart.php') ? 'active' : '' ?>" href="cart.php">
                        <i class="bi bi-cart me-1"></i> Keranjang
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'riwayat.php') ? 'active' : '' ?> text-nowrap" href="riwayat.php">
                            <i class="bi bi-clock-history me-1"></i> Pesanan
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto align-items-xl-center gap-2 gap-xl-3 mt-2 mt-xl-0 pb-3 pb-xl-0">
                <!-- Desktop Dark Mode Toggle -->
                <li class="nav-item d-none d-xl-block">
                    <button class="btn btn-outline-light btn-sm dark-mode-toggle text-nowrap" type="button" aria-label="Toggle Dark Mode">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Profil (Sejajar di Mobile, Text putih di Desktop) -->
                    <li class="nav-item d-none d-xl-block">
                        <a href="#" class="nav-link user-greeting text-nowrap" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="bi bi-person-circle me-1"></i> Hai, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>
                        </a>
                    </li>
                    
                    <!-- Admin Panel -->
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item d-xl-none">
                            <a class="nav-link text-warning fw-bold text-nowrap" href="admin/index.php">
                                <i class="bi bi-shield-lock me-1"></i> Admin Panel
                            </a>
                        </li>
                        <li class="nav-item d-none d-xl-block">
                            <a class="btn btn-warning btn-sm fw-bold text-nowrap" href="admin/index.php">
                                <i class="bi bi-shield-lock me-1"></i> Admin Panel
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Logout -->
                    <li class="nav-item d-xl-none">
                        <a class="nav-link text-danger fw-bold text-nowrap" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a class="btn btn-danger btn-sm fw-bold text-nowrap" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                    <!-- Daftar -->
                    <li class="nav-item d-xl-none">
                        <a class="nav-link text-light fw-bold" href="register.php">
                            <i class="bi bi-person-plus me-1"></i> Daftar
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a class="btn btn-light btn-sm text-primary fw-bold" href="register.php">
                            <i class="bi bi-person-plus me-1"></i> Daftar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php 
    if (isset($_SESSION['flash_msg'])) {
        echo $_SESSION['flash_msg'];
        unset($_SESSION['flash_msg']);
    }
    ?>

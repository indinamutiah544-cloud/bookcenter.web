<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Keamanan: Cek apakah login dan apakah rolenya admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Book Store Center</title>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/darkmode.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-xl navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center text-nowrap" href="index.php">
            <i class="bi bi-shield-lock me-2"></i> Admin Panel
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
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'kategori.php') ? 'active' : '' ?>" href="kategori.php">Kategori</a></li>
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'buku.php') ? 'active' : '' ?>" href="buku.php">Buku</a></li>
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'pesanan.php') ? 'active' : '' ?>" href="pesanan.php">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : '' ?>" href="users.php">Pengguna</a></li>
                <li class="nav-item"><a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : '' ?>" href="about.php">Tentang</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-xl-center gap-2 gap-xl-3 mt-2 mt-xl-0 pb-3 pb-xl-0">
                <!-- Desktop Dark Mode Toggle -->
                <li class="nav-item d-none d-xl-block">
                    <button class="btn btn-outline-light btn-sm dark-mode-toggle text-nowrap" type="button" aria-label="Toggle Dark Mode">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Profil -->
                    <li class="nav-item d-none d-xl-block">
                        <a href="#" class="nav-link text-white fw-bold text-nowrap" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['name']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                
                <!-- Ke Toko -->
                <li class="nav-item d-xl-none">
                    <a class="nav-link text-light fw-bold text-nowrap" href="../index.php">
                        <i class="bi bi-shop me-1"></i> Ke Toko
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a class="btn btn-outline-light btn-sm fw-bold text-nowrap" href="../index.php">
                        <i class="bi bi-shop me-1"></i> Ke Toko
                    </a>
                </li>
                
                <!-- Logout -->
                <li class="nav-item d-xl-none">
                    <a class="nav-link text-danger fw-bold text-nowrap" href="../logout.php" onclick="return confirm('Logout dari Admin?')">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a class="btn btn-danger btn-sm fw-bold text-nowrap" href="../logout.php" onclick="return confirm('Logout dari Admin?')">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </li>
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
<!-- Konten Admin Mulai -->
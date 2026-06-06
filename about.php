<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<!-- <section class="py-5 text-center rounded-4 mb-5 position-relative overflow-hidden shadow-sm" style="background: var(--bs-primary); color: white;">
    <div class="container position-relative z-1 py-4">
        <i class="bi bi-book-half display-1 mb-3 opacity-75"></i>
        <h1 class="fw-bold display-4 mb-3 text-white">Book Store Center</h1>
        <p class="lead mb-0 mx-auto opacity-90 text-white" style="max-width: 700px;">
            Sistem Informasi Pembelian Buku
        </p>
    </div>
</section> -->

<div class="container mb-5 pb-5">
    <!-- Deskripsi Aplikasi -->
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-10">
    <div class="pt-4 pb-0 text-center">
        <h3 class="fw-bold text-primary mb-4"><i class="bi bi-info-circle me-2 mb-2"></i>Tentang Aplikasi</h3>
    </div>
    <div class="p-4 p-md-5" style="text-align: justify;">
        <p class="fs-5 mb-0" style="line-height: 1.8;">
            <strong>Book Store Center</strong> adalah platform toko buku online yang menyediakan berbagai jenis buku, mulai dari buku pelajaran, novel, komik, hingga buku pengembangan diri dan religi. Dengan tampilan yang mudah digunakan, pengguna dapat mencari, membeli, dan membaca informasi buku secara praktis kapan saja dan di mana saja.
        </p>
    </div>
</div>
    </div>

    <hr class="my-5 opacity-25">

    <!-- Informasi Kelompok -->
    <div class="text-center mb-5">
        <span class="badge bg-primary rounded-pill px-3 py-2 mb-3 fw-bold fs-6">Mata Kuliah Pemrograman Web Dasar</span>
        <h2 class="fw-bold mb-2">Tim Pengembang</h2>
        <h5 class="text-muted">Kelompok 5</h5>
        <h5 class="text-muted">Universitas Muhammadiyah Sumatera Utara</h5>
    </div>

    <!-- Ketua -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-5">
            <div class="card shadow-sm rounded-4 text-center border-primary border-2">
                <div class="card-body p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3 shadow" style="width: 80px; height: 80px;">
                        <i class="bi bi-star-fill fs-2"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary rounded-pill px-3 py-1 mb-2">Ketua Kelompok</span>
                        <h4 class="fw-bold mb-1">Balqis Enggelin Iswanto</h4>
                        <p class="mb-0 fs-5 text-muted fw-semibold">NPM: 2409010318</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota -->
    <div class="row g-4 justify-content-center mb-5">
        <!-- Anggota 1 -->
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm rounded-4 h-100 border-0">
                <div class="card-body p-4 d-flex align-items-center text-start">
                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle me-4 flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary rounded-pill px-2 py-1 mb-1" style="font-size: 0.75rem;">Anggota</span>
                        <h5 class="fw-bold mb-1">Andika Dwi Putra</h5>
                        <p class="mb-0 text-muted fw-semibold">NPM: 2409010010</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota 2 -->
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm rounded-4 h-100 border-0">
                <div class="card-body p-4 d-flex align-items-center text-start">
                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle me-4 flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary rounded-pill px-2 py-1 mb-1" style="font-size: 0.75rem;">Anggota</span>
                        <h5 class="fw-bold mb-1">Indina Mutiah</h5>
                        <p class="mb-0 text-muted fw-semibold">NPM: 2409010265</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota 3 -->
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm rounded-4 h-100 border-0">
                <div class="card-body p-4 d-flex align-items-center text-start">
                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle me-4 flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary rounded-pill px-2 py-1 mb-1" style="font-size: 0.75rem;">Anggota</span>
                        <h5 class="fw-bold mb-1">Farhan Ansyari</h5>
                        <p class="mb-0 text-muted fw-semibold">NPM: 2409010150</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota 4 -->
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm rounded-4 h-100 border-0">
                <div class="card-body p-4 d-flex align-items-center text-start">
                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded-circle me-4 flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary rounded-pill px-2 py-1 mb-1" style="font-size: 0.75rem;">Anggota</span>
                        <h5 class="fw-bold mb-1">Ahmad Irsan Rambe</h5>
                        <p class="mb-0 text-muted fw-semibold">NPM: 2409010319</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teknologi yang digunakan -->
    <div class="text-center mt-5 pt-4">
        <h4 class="fw-bold mb-4 text-muted">Teknologi Pendukung</h4>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <div class="d-flex align-items-center card border-0 shadow-sm rounded-pill px-4 py-2">
                <div class="card-body p-0 d-flex align-items-center">
                    <i class="bi bi-filetype-php fs-4 text-primary me-2"></i> 
                    <span class="fw-semibold">PHP Native</span>
                </div>
            </div>
            <div class="d-flex align-items-center card border-0 shadow-sm rounded-pill px-4 py-2">
                <div class="card-body p-0 d-flex align-items-center">
                    <i class="bi bi-database-fill fs-4 text-secondary me-2"></i> 
                    <span class="fw-semibold">MySQL</span>
                </div>
            </div>
            <div class="d-flex align-items-center card border-0 shadow-sm rounded-pill px-4 py-2">
                <div class="card-body p-0 d-flex align-items-center">
                    <i class="bi bi-bootstrap-fill fs-4 text-primary me-2"></i> 
                    <span class="fw-semibold">Bootstrap 5</span>
                </div>
            </div>
            <div class="d-flex align-items-center card border-0 shadow-sm rounded-pill px-4 py-2">
                <div class="card-body p-0 d-flex align-items-center">
                    <i class="bi bi-browser-chrome fs-4 text-success me-2"></i> 
                    <span class="fw-semibold">Responsive Design</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<?php
// Ingat, path koneksi mundur satu folder ('../')
require_once '../config/koneksi.php';
require_once 'includes/header.php';

// 1. Hitung Pesanan Menunggu Validasi (Sudah upload bukti)
$query_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM orders WHERE status = 'waiting_verification'");
$data_pending = mysqli_fetch_assoc($query_pending);
$total_pending = $data_pending['total'];

// 2. Hitung Total Buku Aktif
$query_buku = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM books");
$data_buku = mysqli_fetch_assoc($query_buku);
$total_buku = $data_buku['total'];

// 3. Hitung Total Pelanggan
$query_user = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$data_user = mysqli_fetch_assoc($query_user);
$total_user = $data_user['total'];

// 4. Hitung Total Pendapatan (Pesanan Selesai)
$query_income = mysqli_query($koneksi, "SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'");
$data_income = mysqli_fetch_assoc($query_income);
$total_income = $data_income['total'] ?? 0; // Jika belum ada, set 0
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-1">Dashboard Admin</h2>
        <p class="text-muted">Selamat datang, <?= htmlspecialchars($_SESSION['name']) ?>.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Card Menunggu Validasi -->
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
            <div class="card-body">
                <h6 class="text-muted mb-2">Menunggu Validasi</h6>
                <h3 class="fw-bold text-warning"><?= $total_pending ?> Pesanan</h3>
                <a href="pesanan.php" class="text-decoration-none small">Lihat Detail &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Card Total Pendapatan -->
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Pendapatan</h6>
                <h3 class="fw-bold text-success">Rp <?= number_format($total_income, 0, ',', '.') ?></h3>
                <small class="text-muted">Dari pesanan selesai</small>
            </div>
        </div>
    </div>

    <!-- Card Total Buku -->
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
            <div class="card-body">
                <h6 class="text-muted mb-2">Katalog Buku</h6>
                <h3 class="fw-bold text-primary"><?= $total_buku ?> Buku</h3>
                <a href="buku.php" class="text-decoration-none small">Kelola Buku &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Card Total Pelanggan -->
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 border-start border-info border-4 h-100">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Pelanggan</h6>
                <h3 class="fw-bold text-info"><?= $total_user ?> User</h3>
            </div>
        </div>
    </div>

    <!-- SHORTCUT CARDS Kategori-->
    <div class="col-6 col-md-3">
        <a href="kategori.php" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-primary border-4 h-100 position-relative">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                            <i class="bi bi-grid-fill fs-5"></i>
                        </div> -->
                        <div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SHORTCUT</small>
                            <h6 class="mb-0 fw-bold text-body mt-1">Kelola Kategori</h6>
                        </div>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-muted opacity-50"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- SHORTCUT CARDS Buku -->
    <div class="col-6 col-md-3">
        <a href="buku.php" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-success border-4 h-100 position-relative">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                            <i class="bi bi-book-fill fs-5"></i>
                        </div> -->
                        <div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SHORTCUT</small>
                            <h6 class="mb-0 fw-bold text-body mt-1">Manajemen Buku</h6>
                        </div>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-muted opacity-50"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- SHORTCUT CARDS Pesanan-->
    <div class="col-6 col-md-3">
        <a href="pesanan.php" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-warning border-4 h-100 position-relative">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3">
                            <i class="bi bi-cart-fill fs-5 text-dark"></i>
                        </div> -->
                        <div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SHORTCUT</small>
                            <h6 class="mb-0 fw-bold text-body mt-1">Kelola Pesanan</h6>
                        </div>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-muted opacity-50"></i>
                </div>
            </div>
        </a>    
    </div>

    <!-- SHORTCUT CARDS Manajemen Pengguna -->
    <div class="col-6 col-md-3">
        <a href="users.php" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-info border-4 h-100 position-relative">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <!-- <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                            <i class="bi bi-people-fill fs-5"></i>
                        </div> -->
                        <div>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SHORTCUT</small>
                            <h6 class="mb-0 fw-bold text-body mt-1">Manajemen Pengguna</h6>
                        </div>
                    </div>
                    <i class="bi bi-box-arrow-up-right text-muted opacity-50"></i>
                </div>
            </div>
        </a>    
    </div>
</div>

<?php
// ===== DATA UNTUK GRAFIK =====

// 5. Pendapatan Bulanan (6 bulan terakhir)
$revenue_labels = [];
$revenue_data = [];
for ($i = 5; $i >= 0; $i--) {
    $bulan = date('Y-m', strtotime("-$i months"));
    $label = date('M Y', strtotime("-$i months"));
    $revenue_labels[] = $label;

    $q = mysqli_query($koneksi, "SELECT COALESCE(SUM(total_amount), 0) as total 
                                 FROM orders 
                                 WHERE status = 'completed' 
                                 AND DATE_FORMAT(created_at, '%Y-%m') = '$bulan'");
    $r = mysqli_fetch_assoc($q);
    $revenue_data[] = (float)$r['total'];
}

// 6. Distribusi Status Pesanan
$status_labels = [];
$status_data = [];
$status_colors = [];
$status_map = [
    'pending' => ['label' => 'Belum Bayar', 'color' => '#fbbf24'],
    'waiting_verification' => ['label' => 'Menunggu Validasi', 'color' => '#60a5fa'],
    'processing' => ['label' => 'Diproses', 'color' => '#818cf8'],
    'shipped' => ['label' => 'Dikirim', 'color' => '#38bdf8'],
    'completed' => ['label' => 'Selesai', 'color' => '#34d399'],
    'cancelled' => ['label' => 'Dibatalkan', 'color' => '#f87171'],
];
$q_status = mysqli_query($koneksi, "SELECT status, COUNT(*) as total FROM orders GROUP BY status");
while ($row = mysqli_fetch_assoc($q_status)) {
    $key = $row['status'];
    if (isset($status_map[$key])) {
        $status_labels[] = $status_map[$key]['label'];
        $status_data[] = (int)$row['total'];
        $status_colors[] = $status_map[$key]['color'];
    }
}

// 7. Buku Terlaris (Top 5)
$top_books_labels = [];
$top_books_data = [];
$q_top = mysqli_query($koneksi, "SELECT b.title, SUM(od.quantity) as total_sold 
                                  FROM order_details od 
                                  JOIN books b ON od.book_id = b.id 
                                  JOIN orders o ON od.order_id = o.id
                                  WHERE o.status != 'cancelled'
                                  GROUP BY od.book_id 
                                  ORDER BY total_sold DESC 
                                  LIMIT 5");
while ($row = mysqli_fetch_assoc($q_top)) {
    // Potong judul jika terlalu panjang
    $judul = mb_strlen($row['title']) > 25 ? mb_substr($row['title'], 0, 22) . '...' : $row['title'];
    $top_books_labels[] = $judul;
    $top_books_data[] = (int)$row['total_sold'];
}
?>

<!-- ===== GRAFIK SECTION ===== -->
<!-- <div class="row g-4 mb-4"> -->
    <!-- Grafik Pendapatan Bulanan (Bar Chart) -->
    <!-- <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>Pendapatan Bulanan</h5>
                <span class="badge bg-success bg-opacity-10 text-success">6 Bulan Terakhir</span>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="280"></canvas>
            </div>
        </div>
    </div> -->

    <!-- Grafik Distribusi Status Pesanan (Doughnut) -->
    <!-- <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Status Pesanan</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <?php if (count($status_data) > 0): ?>
                    <canvas id="statusChart" height="260"></canvas>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada data pesanan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> -->

<!-- Grafik Buku Terlaris (Horizontal Bar) -->
<!-- <div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top 5 Buku Terlaris</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary">Berdasarkan Jumlah Terjual</span>
            </div>
            <div class="card-body">
                <?php if (count($top_books_data) > 0): ?>
                    <canvas id="topBooksChart" height="180"></canvas>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada data penjualan buku.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> -->

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#8a92a6' : '#6c757d';
    const tooltipBg = isDark ? '#252a3a' : '#fff';
    const tooltipText = isDark ? '#e8ebf0' : '#212529';
    const tooltipBorder = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

    // Default Chart.js settings
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = textColor;

    // ===== 1. REVENUE BAR CHART =====
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueGradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 280);
        revenueGradient.addColorStop(0, isDark ? 'rgba(108,140,255,0.8)' : 'rgba(13,110,253,0.85)');
        revenueGradient.addColorStop(1, isDark ? 'rgba(108,140,255,0.2)' : 'rgba(13,110,253,0.3)');

        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($revenue_labels) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode($revenue_data) ?>,
                    backgroundColor: revenueGradient,
                    borderColor: isDark ? '#6c8cff' : '#0d6efd',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 40,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        cornerRadius: 10,
                        padding: 12,
                        callbacks: {
                            label: function(ctx) {
                                return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { weight: 500 } }
                    },
                    y: {
                        grid: { color: gridColor },
                        border: { dash: [4, 4] },
                        ticks: {
                            color: textColor,
                            callback: function(val) {
                                if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                                if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + ' Rb';
                                return 'Rp ' + val;
                            }
                        }
                    }
                }
            }
        });
    }

    // ===== 2. ORDER STATUS DOUGHNUT =====
    <?php if (count($status_data) > 0): ?>
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($status_labels) ?>,
                datasets: [{
                    data: <?= json_encode($status_data) ?>,
                    backgroundColor: <?= json_encode($status_colors) ?>,
                    borderColor: isDark ? '#181b23' : '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            padding: 15,
                            usePointStyle: true,
                            pointStyleWidth: 10,
                            font: { size: 11, weight: 500 }
                        }
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        cornerRadius: 10,
                        padding: 12,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = ((ctx.raw / total) * 100).toFixed(1);
                                return ctx.label + ': ' + ctx.raw + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
    <?php endif; ?>

    // ===== 3. TOP BOOKS HORIZONTAL BAR =====
    <?php if (count($top_books_data) > 0): ?>
    const topCtx = document.getElementById('topBooksChart');
    if (topCtx) {
        const bookColors = [
            isDark ? '#6c8cff' : '#0d6efd',
            isDark ? '#34d399' : '#198754',
            isDark ? '#fbbf24' : '#ffc107',
            isDark ? '#818cf8' : '#6f42c1',
            isDark ? '#f87171' : '#dc3545',
        ];

        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($top_books_labels) ?>,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: <?= json_encode($top_books_data) ?>,
                    backgroundColor: bookColors.map(c => c + (isDark ? '99' : 'cc')),
                    borderColor: bookColors,
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 28,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: tooltipBorder,
                        borderWidth: 1,
                        cornerRadius: 10,
                        padding: 12,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.raw + ' terjual';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        border: { dash: [4, 4] },
                        ticks: {
                            color: textColor,
                            stepSize: 1,
                            font: { weight: 500 }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            color: textColor,
                            font: { weight: 600, size: 12 },
                            crossAlign: 'far'
                        }
                    }
                }
            }
        });
    }
    <?php endif; ?>
});
</script>

<?php require_once 'includes/footer.php'; ?>
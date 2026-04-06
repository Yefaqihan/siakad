<?php
// ============================================
// Layout Dashboard (Sidebar + Header + Content)
// Variabel yang harus tersedia: $viewFile, $data (opsional)
// ============================================
 $user = currentUser();
 $role = currentRole();
 $currentPage = $_GET['page'] ?? 'dashboard';
 $currentAction = $_GET['action'] ?? 'index';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? ucfirst($currentPage)) ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/custom.css" rel="stylesheet">
</head>
<body class="dashboard-body">

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="sidebar-brand-text">
                <span class="brand-name"><?= APP_NAME ?></span>
                <span class="brand-sub">Akademik Sekolah</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">MENU UTAMA</div>

            <a href="<?= BASE_URL ?>/index.php?page=dashboard"
               class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <?php if (hasPermission('siswa')): ?>
            <a href="<?= BASE_URL ?>/index.php?page=siswa"
               class="nav-link <?= $currentPage === 'siswa' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                <span>Data Siswa</span>
            </a>
            <?php endif; ?>

            <?php if (hasPermission('nilai')): ?>
            <a href="<?= BASE_URL ?>/index.php?page=nilai"
               class="nav-link <?= $currentPage === 'nilai' ? 'active' : '' ?>">
                <i class="bi bi-journal-check"></i>
                <span>Nilai</span>
            </a>
            <?php endif; ?>

            <?php if (hasPermission('kehadiran')): ?>
            <a href="<?= BASE_URL ?>/index.php?page=kehadiran"
               class="nav-link <?= $currentPage === 'kehadiran' ? 'active' : '' ?>">
                <i class="bi bi-calendar-check"></i>
                <span>Kehadiran</span>
            </a>
            <?php endif; ?>

            <?php if (hasPermission('materi')): ?>
            <a href="<?= BASE_URL ?>/index.php?page=materi"
               class="nav-link <?= $currentPage === 'materi' ? 'active' : '' ?>">
                <i class="bi bi-book"></i>
                <span>Materi</span>
            </a>
            <?php endif; ?>

            <?php if (hasPermission('rapor')): ?>
            <a href="<?= BASE_URL ?>/index.php?page=rapor"
               class="nav-link <?= $currentPage === 'rapor' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Rapor</span>
            </a>
            <?php endif; ?>

            <?php if (hasPermission('users')): ?>
            <div class="nav-section-label mt-2">PENGATURAN</div>
            <a href="<?= BASE_URL ?>/index.php?page=users"
               class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                <i class="bi bi-person-gear"></i>
                <span>Kelola Pengguna</span>
            </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    <?= strtoupper(mb_substr($user['nama'], 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= e($user['nama']) ?></span>
                    <span class="user-role"><?= roleLabel($user['role']) ?></span>
                </div>
                <a href="<?= BASE_URL ?>/index.php?page=logout"
                   class="btn-logout" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="d-flex align-items-center">
                <button class="btn-menu" id="btnMenu" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="breadcrumb" class="ms-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active"><?= e($pageTitle ?? ucfirst($currentPage)) ?></li>
                    </ol>
                </nav>
            </div>
            <div class="header-actions">
                <span class="header-date">
                    <i class="bi bi-calendar3 me-1"></i>
                    <?= formatTanggal(date('Y-m-d')) ?>
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            <!-- Flash Messages -->
            <?php if (hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= getFlash('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?= getFlash('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php
            // Render content view
            if (file_exists($viewFile)) {
                include $viewFile;
            } else {
                echo '<div class="alert alert-warning">Halaman tidak ditemukan.</div>';
            }
            ?>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle rounded-circle" style="width:64px;height:64px;">
                            <i class="bi bi-trash3 text-danger" style="font-size:28px;"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2">Hapus Data?</h6>
                    <p class="text-muted small mb-0" id="deleteMessage">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger rounded-3 px-4" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
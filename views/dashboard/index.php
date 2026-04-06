<?php
 $pageTitle = 'Dashboard';
 $role = currentRole();
?>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-blue">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value" data-count="<?= $data['totalSiswa'] ?>">0</span>
                <span class="stat-label">Total Siswa</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-green">
            <div class="stat-icon"><i class="bi bi-person-workspace"></i></div>
            <div class="stat-info">
                <span class="stat-value" data-count="<?= $data['totalGuru'] ?>">0</span>
                <span class="stat-label">Total Guru</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-amber">
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-info">
                <span class="stat-value" data-count="<?= $data['rataRataNilai'] ?>" data-decimal="1">0</span>
                <span class="stat-label">Rata-rata Nilai</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-teal">
            <div class="stat-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value" data-count="<?= $data['kehadiranHariIni']['hadir'] ?? 0 ?>">0</span>
                <span class="stat-label">Hadir Hari Ini</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Rata-rata Nilai per Kelas</h6>
            </div>
            <div class="content-card-body">
                <canvas id="chartNilaiKelas" height="260"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="content-card">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Distribusi Nilai</h6>
            </div>
            <div class="content-card-body d-flex align-items-center justify-content-center">
                <canvas id="chartDistribusi" height="260"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row g-3">
    <!-- Kehadiran Hari Ini -->
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Kehadiran Hari Ini</h6>
            </div>
            <div class="content-card-body">
                <?php
                $kh = $data['kehadiranHariIni'];
                $total = (int)($kh['total'] ?? 0);
                $hadir = (int)($kh['hadir'] ?? 0);
                $izin = (int)($kh['izin'] ?? 0);
                $sakit = (int)($kh['sakit'] ?? 0);
                $alfa = (int)($kh['alfa'] ?? 0);
                $persenHadir = $total > 0 ? round(($hadir / $total) * 100) : 0;
                ?>
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                         style="width:80px;height:80px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
                        <span class="fw-bold" style="font-size:1.5rem;color:#16a34a;"><?= $persenHadir?>%</span>
                    </div>
                    <p class="text-muted small mb-0">Persentase Kehadiran</p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center px-2 py-1 rounded-2" style="background:#f0fdf4;">
                        <span class="small"><i class="bi bi-check-circle-fill text-success me-2"></i>Hadir</span>
                        <span class="fw-semibold text-success"><?= $hadir ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center px-2 py-1 rounded-2" style="background:#eff6ff;">
                        <span class="small"><i class="bi bi-info-circle-fill text-info me-2"></i>Izin</span>
                        <span class="fw-semibold text-info"><?= $izin ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center px-2 py-1 rounded-2" style="background:#fffbeb;">
                        <span class="small"><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>Sakit</span>
                        <span class="fw-semibold text-warning"><?= $sakit ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center px-2 py-1 rounded-2" style="background:#fef2f2;">
                        <span class="small"><i class="bi bi-x-circle-fill text-danger me-2"></i>Alfa</span>
                        <span class="fw-semibold text-danger"><?= $alfa ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Siswa per Kelas -->
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Siswa per Kelas</h6>
            </div>
            <div class="content-card-body">
                <?php if (!empty($data['siswaPerKelas'])): ?>
                    <?php
                    $maxSiswa = max($data['siswaPerKelas']);
                    foreach ($data['siswaPerKelas'] as $kelas => $jumlah):
                        $width = $maxSiswa > 0 ? round(($jumlah / $maxSiswa) * 100) : 0;
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-medium">Kelas <?= e($kelas) ?></span>
                            <span class="small text-muted"><?= $jumlah ?> siswa</span>
                        </div>
                        <div class="progress" style="height:8px;border-radius:4px;background:#e2e8f0;">
                            <div class="progress-bar" style="width:<?= $width ?>%;background:linear-gradient(90deg,#1d4ed8,#3b82f6);border-radius:4px;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center small">Belum ada data kelas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Rapor Stats (Admin & Kepsek) -->
    <?php if (in_array($role, ['admin', 'kepala_sekolah']) && isset($data['raporStats'])): ?>
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Statistik Rapor 2024/2025</h6>
            </div>
            <div class="content-card-body">
                <?php
                $rs = $data['raporStats'];
                $totalRapor = (int)($rs['total'] ?? 0);
                $verifiedRapor = (int)($rs['verified'] ?? 0);
                $draftRapor = (int)($rs['draft'] ?? 0);
                $avgRapor = round($rs['avg_rata'] ?? 0, 1);
                $persenVerified = $totalRapor > 0 ? round(($verifiedRapor / $totalRapor) * 100) : 0;
                ?>
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2"
                         style="width:80px;height:80px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);">
                        <span class="fw-bold" style="font-size:1.2rem;color:#1d4ed8;"><?= $persenVerified ?>%</span>
                    </div>
                    <p class="text-muted small mb-0">Rapor Terverifikasi</p>
                </div>
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#f8fafc;">
                            <div class="fw-bold text-primary"><?= $totalRapor ?></div>
                            <div class="small text-muted">Total</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#f0fdf4;">
                            <div class="fw-bold text-success"><?= $verifiedRapor ?></div>
                            <div class="small text-muted">Verified</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#fffbeb;">
                            <div class="fw-bold text-warning"><?= $draftRapor ?></div>
                            <div class="small text-muted">Draft</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 p-2 rounded-3 text-center" style="background:#f8fafc;">
                    <span class="small text-muted">Rata-rata Nilai Rapor</span>
                    <div class="fw-bold fs-5 text-primary"><?= $avgRapor ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Aktivitas Terbaru (untuk Guru) -->
    <div class="col-lg-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Aktivitas Terbaru</h6>
            </div>
            <div class="content-card-body">
                <?php if (!empty($data['recentAttendance'])): ?>
                    <?php foreach ($data['recentAttendance'] as $ra): ?>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                             style="width:36px;height:36px;background:#f0f9ff;">
                            <i class="bi bi-calendar-check text-primary" style="font-size:14px;"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="small fw-medium text-truncate"><?= e($ra['siswa_nama']) ?></div>
                            <div class="small text-muted"><?= e($ra['kelas']) ?> &middot; <?= formatTanggal($ra['tanggal']) ?></div>
                        </div>
                        <?= badgeKehadiran($ra['status']) ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center small">Belum ada aktivitas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Bar Chart: Rata-rata per Kelas ---
    const kelasLabels = <?= json_encode(array_map(function($k) { return 'Kelas ' . $k; }, array_keys($data['rataPerKelas']))) ?>;
    const kelasData = <?= json_encode(array_values($data['rataPerKelas'])) ?>;

    new Chart(document.getElementById('chartNilaiKelas'), {
        type: 'bar',
        data: {
            labels: kelasLabels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: kelasData,
                backgroundColor: [
                    'rgba(29,78,216,0.8)', 'rgba(59,130,246,0.8)',
                    'rgba(14,165,233,0.8)', 'rgba(56,189,248,0.8)',
                    'rgba(99,102,241,0.8)', 'rgba(139,92,246,0.8)'
                ],
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 50,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: function(ctx) { return 'Rata-rata: ' + ctx.parsed.y; }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // --- Doughnut Chart: Distribusi Nilai ---
    const dist = <?= json_encode($data['distribusi']) ?>;
    new Chart(document.getElementById('chartDistribusi'), {
        type: 'doughnut',
        data: {
            labels: ['A (90+)', 'B (80-89)', 'C (70-79)', 'D (60-69)', 'E (<60)'],
            datasets: [{
                data: [dist.A || 0, dist.B || 0, dist.C || 0, dist.D || 0, dist.E || 0],
                backgroundColor: ['#16a34a', '#2563eb', '#d97706', '#ea580c', '#dc2626'],
                borderWidth: 0,
                spacing: 3,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 12, usePointStyle: true, pointStyleWidth: 8, font: { size: 11 } }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 10,
                    cornerRadius: 8,
                }
            }
        }
    });
});
</script>
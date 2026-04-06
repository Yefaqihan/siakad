<?php
 $pageTitle = 'Detail Rapor - ' . e($data['siswa']['nama']);
 $nilai = $data['nilaiList'];
 $rekap = $data['rekapHadir'];
 $rapor = $data['rapor'];
 $siswa = $data['siswa'];
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=rapor" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Detail Rapor</h5>
    <?= badgeRapor($rapor['status']) ?>
</div>

<!-- Info Siswa -->
<div class="content-card mb-3">
    <div class="content-card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" style="width:120px;">Nama</td><td class="fw-semibold"><?= e($siswa['nama']) ?></td></tr>
                    <tr><td class="text-muted">NIS</td><td><?= e($siswa['nis']) ?></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" style="width:120px;">Kelas</td><td class="fw-semibold"><?= e($siswa['kelas']) ?></td></tr>
                    <tr><td class="text-muted">Semester</td><td><?= e($rapor['semester']) ?> - <?= e($rapor['tahun_ajaran']) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Tabel Nilai -->
    <div class="col-lg-7">
        <div class="content-card">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Daftar Nilai</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="table-light">
                            <th class="ps-3">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($nilai)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada nilai.</td></tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($nilai as $n): ?>
                            <tr>
                                <td class="ps-3 text-muted"><?= $no++ ?></td>
                                <td><?= e($n['nama_mapel']) ?></td>
                                <td class="fw-bold <?= $n['nilai_angka'] >= 75 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($n['nilai_angka'], 0) ?>
                                </td>
                                <td>
                                    <span class="badge <?= $n['nilai_angka'] >= 75 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> rounded-2">
                                        <?= getPredikat($n['nilai_angka']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($nilai)): ?>
                    <tfoot>
                        <tr class="table-light fw-bold">
                            <td colspan="2" class="ps-3">Rata-rata</td>
                            <td class="text-primary fs-5"><?= number_format($rapor['rata_rata'], 1) ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-2"><?= e($rapor['predikat']) ?></span>
                            </td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Rekap Kehadiran -->
    <div class="col-lg-5">
        <div class="content-card">
            <div class="content-card-header">
                <h6 class="mb-0 fw-semibold">Rekap Kehadiran</h6>
            </div>
            <div class="content-card-body">
                <?php if ($rekap): ?>
                <div class="text-center mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                         style="width:90px;height:90px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
                        <?php
                        $totalH = (int)($rekap['total'] ?? 0);
                        $hadirH = (int)($rekap['hadir'] ?? 0);
                        $persenH = $totalH > 0 ? round(($hadirH / $totalH) * 100) : 0;
                        ?>
                        <span class="fw-bold" style="font-size:1.3rem;color:#16a34a;"><?= $persenH ?>%</span>
                    </div>
                    <p class="text-muted small mt-1 mb-0">Persentase Kehadiran</p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#f0fdf4;">
                        <span class="small"><i class="bi bi-check-circle-fill text-success me-2"></i>Hadir</span>
                        <span class="fw-semibold"><?= $hadirH ?> hari</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#eff6ff;">
                        <span class="small"><i class="bi bi-info-circle-fill text-info me-2"></i>Izin</span>
                        <span class="fw-semibold"><?= (int)($rekap['izin'] ?? 0) ?> hari</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#fffbeb;">
                        <span class="small"><i class="bi bi-exclamation-circle-fill text-warning me-2"></i>Sakit</span>
                        <span class="fw-semibold"><?= (int)($rekap['sakit'] ?? 0) ?> hari</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#fef2f2;">
                        <span class="small"><i class="bi bi-x-circle-fill text-danger me-2"></i>Alfa</span>
                        <span class="fw-semibold"><?= (int)($rekap['alfa'] ?? 0) ?> hari</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3 mt-1" style="background:#f8fafc;">
                        <span class="small fw-medium">Total Hari</span>
                        <span class="fw-bold"><?= $totalH ?> hari</span>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-muted text-center">Belum ada data kehadiran.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($rapor['status'] === 'verified'): ?>
        <div class="content-card mt-3">
            <div class="content-card-body text-center">
                <i class="bi bi-patch-check-fill text-success" style="font-size:1.5rem;"></i>
                <p class="fw-semibold mb-0 mt-1">Rapor Terverifikasi</p>
                <p class="text-muted small mb-0">Oleh: <?= e($rapor['verified_name'] ?? '-') ?></p>
                <p class="text-muted small mb-0"><?= $rapor['verified_at'] ? formatTanggal($rapor['verified_at']) : '-' ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
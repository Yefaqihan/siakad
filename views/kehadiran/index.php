<?php $pageTitle = 'Kehadiran'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Kehadiran</h5>
    <a href="<?= BASE_URL ?>/index.php?page=kehadiran&action=create" class="btn btn-primary rounded-3 px-4">
        <i class="bi bi-plus-lg me-1"></i>Input Kehadiran
    </a>
</div>

<!-- Filter -->
<div class="content-card mb-3">
    <div class="content-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="kehadiran">
            <div class="col-md-4">
                <label class="form-label small text-muted">Kelas</label>
                <select name="kelas" class="form-select form-select-sm rounded-3">
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($data['kelasList'] as $kelas): ?>
                        <option value="<?= e($kelas) ?>" <?= ($data['filterKelas'] ?? '') === $kelas ? 'selected' : '' ?>>
                            Kelas <?= e($kelas) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm rounded-3"
                       value="<?= e($data['tanggal']) ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Kehadiran -->
<?php if (!empty($data['filterKelas'])): ?>
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Kehadiran Kelas <?= e($data['filterKelas']) ?> - <?= formatTanggal($data['tanggal']) ?></h6>
        <span class="small text-muted"><?= count($data['kehadiran']) ?> data</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-3">No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['kehadiran'])): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x" style="font-size:2rem;"></i>
                        <p class="mb-0 mt-1">Belum ada data kehadiran untuk tanggal ini.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($data['kehadiran'] as $k): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td><span class="font-monospace small"><?= e($k['nis']) ?></span></td>
                        <td class="fw-medium"><?= e($k['nama']) ?></td>
                        <td><?= e($k['kelas']) ?></td>
                        <td><?= badgeKehadiran($k['status']) ?></td>
                        <td class="text-muted small"><?= e($k['keterangan'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="content-card text-center py-5">
    <i class="bi bi-funnel" style="font-size:2.5rem;color:#cbd5e1;"></i>
    <p class="text-muted mt-2 mb-0">Pilih kelas dan tanggal untuk menampilkan kehadiran.</p>
</div>
<?php endif; ?>
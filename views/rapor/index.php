<?php $pageTitle = 'Rapor Siswa'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Rapor Siswa</h5>
    <?php if (currentRole() === 'admin'): ?>
    <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#generateModal">
        <i class="bi bi-magic me-1"></i>Generate Rapor
    </button>
    <?php endif; ?>
</div>

<!-- Filter -->
<div class="content-card mb-3">
    <div class="content-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="rapor">
            <div class="col-md-3">
                <label class="form-label small text-muted">Semester</label>
                <select name="semester" class="form-select form-select-sm rounded-3">
                    <option value="Ganjil" <?= ($data['semester'] ?? '') === 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= ($data['semester'] ?? '') === 'Genap' ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-select form-select-sm rounded-3">
                    <option value="2024/2025" <?= ($data['tahunAjaran'] ?? '') === '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
                    <option value="2023/2024" <?= ($data['tahunAjaran'] ?? '') === '2023/2024' ? 'selected' : '' ?>>2023/2024</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Kelas</label>
                <select name="kelas" class="form-select form-select-sm rounded-3">
                    <option value="">Semua</option>
                    <?php foreach ($data['kelasList'] as $kelas): ?>
                        <option value="<?= e($kelas) ?>" <?= ($data['filterKelas'] ?? '') === $kelas ? 'selected' : '' ?>><?= e($kelas) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="">Semua</option>
                    <option value="draft" <?= ($data['filterStatus'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="verified" <?= ($data['filterStatus'] ?? '') === 'verified' ? 'selected' : '' ?>>Verified</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Rapor -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-3">No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Rata-rata</th>
                    <th>Predikat</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['rapor'])): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-file-earmark-text" style="font-size:2rem;"></i>
                        <p class="mb-0 mt-1">Belum ada data rapor. Generate terlebih dahulu.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($data['rapor'] as $r): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td><span class="font-monospace small"><?= e($r['nis']) ?></span></td>
                        <td class="fw-medium"><?= e($r['siswa_nama']) ?></td>
                        <td><?= e($r['kelas']) ?></td>
                        <td>
                            <span class="fw-bold <?= $r['rata_rata'] >= 75 ? 'text-success' : 'text-danger' ?>">
                                <?= number_format($r['rata_rata'], 1) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $r['rata_rata'] >= 75 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> rounded-2">
                                <?= e($r['predikat']) ?>
                            </span>
                        </td>
                        <td><?= badgeRapor($r['status']) ?></td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>/index.php?page=rapor&action=detail&id=<?= $r['id'] ?>"
                               class="btn btn-sm btn-outline-primary rounded-2 px-2" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if (in_array(currentRole(), ['admin', 'kepala_sekolah'])): ?>
                            <form method="POST" action="<?= BASE_URL ?>/index.php?page=rapor&action=verify&id=<?= $r['id'] ?>" style="display:inline;">
                                <?= csrfField() ?>
                                <button type="submit" class="btn btn-sm <?= $r['status'] === 'verified' ? 'btn-outline-warning' : 'btn-outline-success' ?> rounded-2 px-2"
                                        title="<?= $r['status'] === 'verified' ? 'Batalkan Verifikasi' : 'Verifikasi' ?>">
                                    <i class="bi <?= $r['status'] === 'verified' ? 'bi-x-circle' : 'bi-check-circle' ?>"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($data['rapor'])): ?>
    <div class="content-card-footer">
        <span class="text-muted small">Menampilkan <?= count($data['rapor']) ?> data</span>
    </div>
    <?php endif; ?>
</div>

<!-- Generate Rapor Modal -->
<?php if (currentRole() === 'admin'): ?>
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold"><i class="bi bi-magic me-2 text-primary"></i>Generate Rapor</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/index.php?page=rapor&action=bulk">
                <?= csrfField() ?>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Sistem akan menghitung rata-rata nilai semua siswa dan membuat rapor baru (draft). Rapor yang sudah ada akan diperbarui rata-ratanya tanpa mengubah status verifikasi.</p>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Semester</label>
                        <select name="semester" class="form-select rounded-3">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-select rounded-3">
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-medium">Kelas (opsional)</label>
                        <select name="kelas" class="form-select rounded-3">
                            <option value="">Semua Kelas</option>
                            <?php foreach ($data['kelasList'] as $kelas): ?>
                                <option value="<?= e($kelas) ?>">Kelas <?= e($kelas) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-magic me-1"></i>Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
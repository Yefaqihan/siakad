<?php $pageTitle = 'Kelola Nilai'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-journal-check me-2 text-primary"></i>Kelola Nilai</h5>
    <a href="<?= BASE_URL ?>/index.php?page=nilai&action=create" class="btn btn-primary rounded-3 px-4">
        <i class="bi bi-plus-lg me-1"></i>Input Nilai
    </a>
</div>

<!-- Filter -->
<div class="content-card mb-3">
    <div class="content-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="nilai">
            <div class="col-md-3">
                <label class="form-label small text-muted">Kelas</label>
                <select name="kelas" class="form-select form-select-sm rounded-3" id="filterKelasNilai">
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($data['kelasList'] as $kelas): ?>
                        <option value="<?= e($kelas) ?>" <?= ($data['filterKelas'] ?? '') === $kelas ? 'selected' : '' ?>>
                            Kelas <?= e($kelas) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
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
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Nilai -->
<?php if (!empty($data['filterKelas'])): ?>
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Nilai Kelas <?= e($data['filterKelas']) ?> - <?= e($data['semester']) ?></h6>
        <span class="small text-muted"><?= count($data['nilai']) ?> data</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-3">No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['nilai'])): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-journal-x" style="font-size:2rem;"></i>
                        <p class="mb-0 mt-1">Belum ada data nilai untuk filter ini.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($data['nilai'] as $n): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td><span class="font-monospace small"><?= e($n['nis']) ?></span></td>
                        <td class="fw-medium"><?= e($n['siswa_nama']) ?></td>
                        <td><?= e($n['nama_mapel']) ?></td>
                        <td>
                            <span class="fw-bold <?= $n['nilai_angka'] >= 75 ? 'text-success' : 'text-danger' ?>">
                                <?= number_format($n['nilai_angka'], 0) ?>
                            </span>
                        </td>
                        <td><span class="badge <?= $n['nilai_angka'] >= 75 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> rounded-2"><?= getPredikat($n['nilai_angka']) ?></span></td>
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
    <p class="text-muted mt-2 mb-0">Pilih kelas untuk menampilkan data nilai.</p>
</div>
<?php endif; ?>
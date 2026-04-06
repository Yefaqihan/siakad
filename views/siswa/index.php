<?php $pageTitle = 'Data Siswa'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Data Siswa</h5>
    <?php if (currentRole() === 'admin'): ?>
    <a href="<?= BASE_URL ?>/index.php?page=siswa&action=create" class="btn btn-primary rounded-3 px-4">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
    </a>
    <?php endif; ?>
</div>

<!-- Filter & Search -->
<div class="content-card mb-3">
    <div class="content-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="siswa">
            <div class="col-md-4">
                <label class="form-label small text-muted">Cari Nama / NIS</label>
                <input type="text" name="q" class="form-control form-control-sm rounded-3"
                       value="<?= e($data['search'] ?? '') ?>" placeholder="Ketik untuk mencari...">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Filter Kelas</label>
                <select name="kelas" class="form-select form-select-sm rounded-3">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($data['kelasList'] as $kelas): ?>
                        <option value="<?= e($kelas) ?>" <?= ($data['filterKelas'] ?? '') === $kelas ? 'selected' : '' ?>>
                            Kelas <?= e($kelas) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="<?= BASE_URL ?>/index.php?page=siswa" class="btn btn-light btn-sm rounded-3 w-100">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Siswa -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-3" style="width:50px;">No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <?php if (currentRole() === 'admin'): ?>
                    <th style="width:140px;" class="text-center">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['siswa'])): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <p class="mb-0 mt-1">Belum ada data siswa.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($data['siswa'] as $s): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td><span class="font-monospace small"><?= e($s['nis']) ?></span></td>
                        <td class="fw-medium"><?= e($s['nama']) ?></td>
                        <td><span class="badge bg-primary-subtle text-primary"><?= e($s['kelas']) ?></span></td>
                        <td><?= $s['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <?php if (currentRole() === 'admin'): ?>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>/index.php?page=siswa&action=edit&id=<?= $s['id'] ?>"
                               class="btn btn-sm btn-outline-primary rounded-2 px-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2 px-2 btn-delete"
                                    data-id="<?= $s['id'] ?>"
                                    data-name="<?= e($s['nama']) ?>"
                                    data-url="<?= BASE_URL ?>/index.php?page=siswa&action=delete&id=<?= $s['id'] ?>"
                                    title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($data['siswa'])): ?>
    <div class="content-card-footer">
        <span class="text-muted small">Menampilkan <?= count($data['siswa']) ?> data</span>
    </div>
    <?php endif; ?>
</div>
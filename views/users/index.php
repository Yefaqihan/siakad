<?php $pageTitle = 'Kelola Pengguna'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-person-gear me-2 text-primary"></i>Kelola Pengguna</h5>
    <a href="<?= BASE_URL ?>/index.php?page=users&action=create" class="btn btn-primary rounded-3 px-4">
        <i class="bi bi-plus-lg me-1"></i>Tambah Pengguna
    </a>
</div>

<!-- Filter Role -->
<div class="content-card mb-3">
    <div class="content-card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="users">
            <div class="col-md-4">
                <label class="form-label small text-muted">Filter Role</label>
                <select name="role" class="form-select form-select-sm rounded-3">
                    <option value="">Semua Role</option>
                    <option value="admin" <?= ($data['filterRole'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="guru" <?= ($data['filterRole'] ?? '') === 'guru' ? 'selected' : '' ?>>Guru</option>
                    <option value="kepala_sekolah" <?= ($data['filterRole'] ?? '') === 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="<?= BASE_URL ?>/index.php?page=users" class="btn btn-light btn-sm rounded-3 w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-3">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['users'])): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-people" style="font-size:2rem;"></i>
                        <p class="mb-0 mt-1">Tidak ada data pengguna.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($data['users'] as $u): ?>
                    <tr>
                        <td class="ps-3 text-muted"><?= $no++ ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold flex-shrink-0"
                                     style="width:36px;height:36px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);font-size:0.8rem;">
                                    <?= strtoupper(mb_substr($u['nama'], 0, 1)) ?>
                                </div>
                                <span class="fw-medium"><?= e($u['nama']) ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?= e($u['email']) ?></td>
                        <td><?= roleLabel($u['role']) ?></td>
                        <td class="text-center">
                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                            <a href="<?= BASE_URL ?>/index.php?page=users&action=edit&id=<?= $u['id'] ?>"
                               class="btn btn-sm btn-outline-primary rounded-2 px-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-2 px-2 btn-delete"
                                    data-id="<?= $u['id'] ?>"
                                    data-name="<?= e($u['nama']) ?>"
                                    data-url="<?= BASE_URL ?>/index.php?page=users&action=delete&id=<?= $u['id'] ?>"
                                    title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </button>
                            <?php else: ?>
                            <span class="small text-muted">Anda</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
 $pageTitle = $data['isEdit'] ? 'Edit Pengguna' : 'Tambah Pengguna';
 $user = $data['user'];
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=users" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0"><?= $pageTitle ?></h5>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7 col-xl-5">
        <div class="content-card">
            <div class="content-card-body p-4">
                <form method="POST"
                      action="<?= BASE_URL ?>/index.php?page=users&action=<?= $data['isEdit'] ? 'update&id=' . $user['id'] : 'store' ?>">
                    <?= csrfField() ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control rounded-3"
                               value="<?= e($user['nama'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3"
                               value="<?= e($user['email'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">
                            Password <?= $data['isEdit'] ? '<span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>' : '<span class="text-danger">*</span>' ?>
                        </label>
                        <input type="password" name="password" class="form-control rounded-3"
                               <?= $data['isEdit'] ? '' : 'required minlength="6"' ?>>
                        <?php if ($data['isEdit']): ?>
                        <div class="form-text">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah.</div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select rounded-3" required>
                            <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="guru" <?= ($user['role'] ?? '') === 'guru' || !$data['isEdit'] ? 'selected' : '' ?>>Guru</option>
                            <option value="kepala_sekolah" <?= ($user['role'] ?? '') === 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/index.php?page=users" class="btn btn-light rounded-3 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-check-lg me-1"></i><?= $data['isEdit'] ? 'Simpan Perubahan' : 'Tambah Pengguna' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
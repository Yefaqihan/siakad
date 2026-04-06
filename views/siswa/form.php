<?php
 $pageTitle = $data['isEdit'] ? 'Edit Siswa' : 'Tambah Siswa';
 $siswa = $data['siswa'];
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=siswa" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0"><?= $pageTitle ?></h5>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6">
        <div class="content-card">
            <div class="content-card-body p-4">
                <form method="POST"
                      action="<?= BASE_URL ?>/index.php?page=siswa&action=<?= $data['isEdit'] ? 'update&id=' . $siswa['id'] : 'store' ?>">
                    <?= csrfField() ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control rounded-3" value="<?= e($siswa['nama'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">NIS <span class="text-danger">*</span></label>
                        <input type="text" name="nis" class="form-control rounded-3" value="<?= e($siswa['nis'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="kelas" class="form-control rounded-3"
                               value="<?= e($siswa['kelas'] ?? '') ?>" placeholder="Contoh: 7A, 8B, 9C" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Jenis Kelamin</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkL" value="L"
                                       <?= ($siswa['jenis_kelamin'] ?? 'L') === 'L' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="jkL">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkP" value="P"
                                       <?= ($siswa['jenis_kelamin'] ?? '') === 'P' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="jkP">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/index.php?page=siswa" class="btn btn-light rounded-3 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-check-lg me-1"></i><?= $data['isEdit'] ? 'Simpan Perubahan' : 'Tambah Siswa' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
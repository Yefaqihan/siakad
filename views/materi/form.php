<?php
 $pageTitle = $data['isEdit'] ? 'Edit Materi' : 'Upload Materi';
 $materi = $data['materi'];
?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=materi" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0"><?= $pageTitle ?></h5>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="content-card">
            <div class="content-card-body p-4">
                <form method="POST" enctype="multipart/form-data"
                      action="<?= BASE_URL ?>/index.php?page=materi&action=<?= $data['isEdit'] ? 'update&id=' . $materi['id'] : 'store' ?>">
                    <?= csrfField() ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control rounded-3"
                               value="<?= e($materi['judul'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select rounded-3">
                            <option value="">-- Tidak terkait mapel --</option>
                            <?php foreach ($data['mapelList'] as $m): ?>
                                <option value="<?= $m['id'] ?>" <?= ($materi['mapel_id'] ?? '') == $m['id'] ? 'selected' : '' ?>>
                                    <?= e($m['nama_mapel']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-3" rows="3"><?= e($materi['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">File Materi</label>
                        <input type="file" name="file" class="form-control rounded-3"
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.png,.zip,.rar">
                        <div class="form-text">Format: PDF, Word, PowerPoint, Excel, Gambar, ZIP/RAR (Maks. 10MB)</div>
                        <?php if ($data['isEdit'] && $materi['file_path']): ?>
                            <div class="mt-2 p-2 rounded-3 d-flex align-items-center gap-2" style="background:#f8fafc;">
                                <i class="bi bi-file-earmark text-primary"></i>
                                <span class="small"><?= e($materi['file_path']) ?></span>
                                <a href="<?= UPLOAD_URL . e($materi['file_path']) ?>" target="_blank" class="small text-primary ms-auto">Lihat</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/index.php?page=materi" class="btn btn-light rounded-3 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-check-lg me-1"></i><?= $data['isEdit'] ? 'Simpan Perubahan' : 'Upload Materi' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
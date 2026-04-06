<?php $pageTitle = 'Materi Pembelajaran'; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-book me-2 text-primary"></i>Materi Pembelajaran</h5>
    <a href="<?= BASE_URL ?>/index.php?page=materi&action=create" class="btn btn-primary rounded-3 px-4">
        <i class="bi bi-plus-lg me-1"></i>Upload Materi
    </a>
</div>

<div class="row g-3">
    <?php if (empty($data['materi'])): ?>
    <div class="col-12">
        <div class="content-card text-center py-5">
            <i class="bi bi-folder2-open" style="font-size:2.5rem;color:#cbd5e1;"></i>
            <p class="text-muted mt-2 mb-0">Belum ada materi pembelajaran.</p>
        </div>
    </div>
    <?php else: ?>
        <?php foreach ($data['materi'] as $m): ?>
        <div class="col-md-6 col-xl-4">
            <div class="content-card h-100">
                <div class="content-card-body">
                    <!-- Icon berdasarkan tipe file -->
                    <?php
                    $ext = strtolower(pathinfo($m['file_path'], PATHINFO_EXTENSION));
                    $iconMap = [
                        'pdf' => 'bi-file-earmark-pdf text-danger',
                        'doc' => 'bi-file-earmark-word text-primary',
                        'docx' => 'bi-file-earmark-word text-primary',
                        'ppt' => 'bi-file-earmark-ppt text-danger',
                        'pptx' => 'bi-file-earmark-ppt text-danger',
                        'xls' => 'bi-file-earmark-excel text-success',
                        'xlsx' => 'bi-file-earmark-excel text-success',
                        'jpg' => 'bi-file-earmark-image text-info',
                        'png' => 'bi-file-earmark-image text-info',
                        'zip' => 'bi-file-earmark-zip text-warning',
                        'rar' => 'bi-file-earmark-zip text-warning',
                    ];
                    $fileIcon = $iconMap[$ext] ?? 'bi-file-earmark text-secondary';
                    ?>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                             style="width:48px;height:48px;background:#f0f9ff;">
                            <i class="bi <?= $fileIcon ?>" style="font-size:1.3rem;"></i>
                        </div>
                        <div class="min-width-0">
                            <h6 class="fw-semibold mb-1 text-truncate" title="<?= e($m['judul']) ?>"><?= e($m['judul']) ?></h6>
                            <?php if (!empty($m['nama_mapel'])): ?>
                                <span class="badge bg-primary-subtle text-primary rounded-2 small"><?= e($m['nama_mapel']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($m['deskripsi'])): ?>
                    <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= e($m['deskripsi']) ?>
                    </p>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                        <span><i class="bi bi-person me-1"></i><?= e($m['guru_nama']) ?></span>
                        <span><?= formatTanggal($m['created_at']) ?></span>
                    </div>

                    <?php if ($m['file_path']): ?>
                    <a href="<?= UPLOAD_URL . e($m['file_path']) ?>" target="_blank"
                       class="btn btn-outline-primary btn-sm rounded-3 w-100 mb-2">
                        <i class="bi bi-download me-1"></i>Unduh File
                    </a>
                    <?php endif; ?>

                    <?php if (currentRole() === 'admin' || $m['guru_id'] == $_SESSION['user_id']): ?>
                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/index.php?page=materi&action=edit&id=<?= $m['id'] ?>"
                           class="btn btn-outline-secondary btn-sm rounded-3 flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3 btn-delete"
                                data-id="<?= $m['id'] ?>"
                                data-name="<?= e($m['judul']) ?>"
                                data-url="<?= BASE_URL ?>/index.php?page=materi&action=delete&id=<?= $m['id'] ?>">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
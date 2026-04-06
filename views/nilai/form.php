<?php $pageTitle = 'Input Nilai'; ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=nilai" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Input Nilai</h5>
</div>

<div class="content-card">
    <div class="content-card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?page=nilai&action=store" id="formNilai">
            <?= csrfField() ?>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-medium">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" class="form-select rounded-3" id="selectKelasNilai" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($data['kelasList'] as $kelas): ?>
                            <option value="<?= e($kelas) ?>"><?= e($kelas) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Mata Pelajaran <span class="text-danger">*</span></label>
                    <select name="mapel_id" class="form-select rounded-3" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach ($data['mapelList'] as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= e($m['nama_mapel']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Semester</label>
                    <select name="semester" class="form-select rounded-3">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select rounded-3">
                        <option value="2024/2025">2024/2025</option>
                        <option value="2023/2024">2023/2024</option>
                    </select>
                </div>
            </div>

            <!-- Daftar siswa akan dimuat via AJAX -->
            <div id="siswaListContainer">
                <div class="text-center text-muted py-4">
                    <i class="bi bi-arrow-up" style="font-size:1.5rem;"></i>
                    <p class="mb-0 mt-1 small">Pilih kelas terlebih dahulu untuk memuat daftar siswa.</p>
                </div>
            </div>

            <div class="d-none" id="btnSubmitContainer">
                <button type="submit" class="btn btn-primary rounded-3 px-4">
                    <i class="bi bi-check-lg me-1"></i>Simpan Semua Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('selectKelasNilai').addEventListener('change', function() {
    const kelas = this.value;
    const container = document.getElementById('siswaListContainer');
    const btnContainer = document.getElementById('btnSubmitContainer');

    if (!kelas) {
        container.innerHTML = '<div class="text-center text-muted py-4"><p class="small mb-0">Pilih kelas terlebih dahulu.</p></div>';
        btnContainer.classList.add('d-none');
        return;
    }

    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="small text-muted mt-2">Memuat data siswa...</p></div>';

    fetch('<?= BASE_URL ?>/api/get_siswa_by_kelas.php?kelas=' + encodeURIComponent(kelas))
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<div class="text-center text-muted py-4"><p class="small mb-0">Tidak ada siswa di kelas ini.</p></div>';
                btnContainer.classList.add('d-none');
                return;
            }

            let html = '<div class="table-responsive"><table class="table table-hover align-middle mb-0">';
            html += '<thead><tr class="table-light"><th class="ps-3">No</th><th>NIS</th><th>Nama</th><th style="width:150px;">Nilai (0-100)</th></tr></thead><tbody>';
            data.forEach((s, i) => {
                html += `<tr>
                    <td class="ps-3 text-muted">${i + 1}</td>
                    <td><span class="font-monospace small">${s.nis}</span></td>
                    <td class="fw-medium">${s.nama}</td>
                    <td><input type="number" name="nilai[${s.id}]" class="form-control form-control-sm rounded-3 nilai-input" min="0" max="100" step="0.01" placeholder="-"></td>
                </tr>`;
            });
            html += '</tbody></table></div>';
            container.innerHTML = html;
            btnContainer.classList.remove('d-none');
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger">Gagal memuat data. Coba lagi.</div>';
        });
});
</script>
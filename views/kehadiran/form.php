<?php $pageTitle = 'Input Kehadiran'; ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= BASE_URL ?>/index.php?page=kehadiran" class="btn btn-light rounded-3 btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Input Kehadiran</h5>
</div>

<div class="content-card">
    <div class="content-card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?page=kehadiran&action=store" id="formKehadiran">
            <?= csrfField() ?>

            <div class="row g-3 mb-4">
                <div class="col-md-5">
                    <label class="form-label fw-medium">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" class="form-select rounded-3" id="selectKelasHadir" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($data['kelasList'] as $kelas): ?>
                            <option value="<?= e($kelas) ?>"><?= e($kelas) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control rounded-3"
                           value="<?= e($data['tanggal']) ?>" required>
                </div>
            </div>

            <div id="siswaHadirContainer">
                <div class="text-center text-muted py-4">
                    <p class="small mb-0">Pilih kelas terlebih dahulu.</p>
                </div>
            </div>

            <div class="d-none mt-3" id="btnHadirContainer">
                <!-- Quick-fill buttons -->
                <div class="mb-3">
                    <span class="small text-muted me-2">Quick-fill:</span>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-2 quick-fill" data-status="hadir">Semua Hadir</button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-2 quick-fill" data-status="alfa">Semua Alfa</button>
                </div>
                <button type="submit" class="btn btn-primary rounded-3 px-4">
                    <i class="bi bi-check-lg me-1"></i>Simpan Kehadiran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('selectKelasHadir').addEventListener('change', function() {
    const kelas = this.value;
    const container = document.getElementById('siswaHadirContainer');
    const btnContainer = document.getElementById('btnHadirContainer');

    if (!kelas) {
        container.innerHTML = '<div class="text-center text-muted py-4"><p class="small mb-0">Pilih kelas terlebih dahulu.</p></div>';
        btnContainer.classList.add('d-none');
        return;
    }

    container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="small text-muted mt-2">Memuat...</p></div>';

    fetch('<?= BASE_URL ?>/api/get_siswa_by_kelas.php?kelas=' + encodeURIComponent(kelas))
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<div class="text-center text-muted py-4"><p class="small mb-0">Tidak ada siswa.</p></div>';
                btnContainer.classList.add('d-none');
                return;
            }

            let html = '<div class="table-responsive"><table class="table table-hover align-middle mb-0">';
            html += '<thead><tr class="table-light"><th class="ps-3">No</th><th>NIS</th><th>Nama</th><th style="width:200px;">Status</th><th style="width:200px;">Keterangan</th></tr></thead><tbody>';
            data.forEach((s, i) => {
                html += `<tr>
                    <td class="ps-3 text-muted">${i + 1}</td>
                    <td><span class="font-monospace small">${s.nis}</span></td>
                    <td class="fw-medium">${s.nama}</td>
                    <td>
                        <select name="status[${s.id}]" class="form-select form-select-sm rounded-2 status-select">
                            <option value="hadir" selected>Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </td>
                    <td><input type="text" name="keterangan[${s.id}]" class="form-control form-control-sm rounded-2" placeholder="Opsional"></td>
                </tr>`;
            });
            html += '</tbody></table></div>';
            container.innerHTML = html;
            btnContainer.classList.remove('d-none');
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger">Gagal memuat data.</div>';
        });
});

// Quick-fill all status
document.querySelectorAll('.quick-fill').forEach(btn => {
    btn.addEventListener('click', function() {
        const status = this.dataset.status;
        document.querySelectorAll('.status-select').forEach(sel => sel.value = status);
    });
});
</script>
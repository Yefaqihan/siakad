<?php
// ============================================
// Controller Rapor
// ============================================

class RaporController
{
    private $raporModel;
    private $siswaModel;
    private $nilaiModel;
    private $kehadiranModel;

    public function __construct()
    {
        $this->raporModel     = new Rapor();
        $this->siswaModel     = new Siswa();
        $this->nilaiModel     = new Nilai();
        $this->kehadiranModel = new Kehadiran();
    }

    public function index()
    {
        $semester    = $_GET['semester'] ?? 'Ganjil';
        $tahunAjaran = $_GET['tahun_ajaran'] ?? '2024/2025';
        $filterKelas = $_GET['kelas'] ?? '';
        $filterStatus = $_GET['status'] ?? '';

        $data['semester']     = $semester;
        $data['tahunAjaran']  = $tahunAjaran;
        $data['filterKelas']  = $filterKelas;
        $data['filterStatus'] = $filterStatus;
        $data['kelasList']    = $this->siswaModel->getKelasList();

        // Ambil semua rapor
        $allRapor = $this->raporModel->getWithSiswa($semester, $tahunAjaran);

        // Filter
        if ($filterKelas) {
            $allRapor = array_filter($allRapor, function ($r) use ($filterKelas) {
                return $r['kelas'] === $filterKelas;
            });
        }
        if ($filterStatus) {
            $allRapor = array_filter($allRapor, function ($r) use ($filterStatus) {
                return $r['status'] === $filterStatus;
            });
        }

        $data['rapor'] = $allRapor;
        $viewFile = __DIR__ . '/../views/rapor/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function detail($id)
    {
        $rapor = $this->raporModel->find($id);
        if (!$rapor) {
            setFlash('error', 'Rapor tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        $siswa = $this->siswaModel->find($rapor['siswa_id']);
        $data['rapor']       = $rapor;
        $data['siswa']       = $siswa;
        $data['nilaiList']   = $this->nilaiModel->getBySiswaSemester(
            $rapor['siswa_id'], $rapor['semester'], $rapor['tahun_ajaran']
        );
        $data['rekapHadir']  = $this->kehadiranModel->getRekap(
            $rapor['siswa_id'], $rapor['semester'], $rapor['tahun_ajaran']
        );

        $viewFile = __DIR__ . '/../views/rapor/detail.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    /**
     * Generate rapor untuk semua siswa
     */
    public function bulk()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        if (currentRole() !== 'admin') {
            setFlash('error', 'Hanya admin yang dapat generate rapor.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        $semester    = $_POST['semester'] ?? 'Ganjil';
        $tahunAjaran = $_POST['tahun_ajaran'] ?? '2024/2025';
        $kelas       = $_POST['kelas'] ?? '';

        $siswaList = $kelas ? $this->siswaModel->getByKelas($kelas) : $this->siswaModel->all();
        $count = 0;

        foreach ($siswaList as $siswa) {
            $rataRata = $this->nilaiModel->getRataRata($siswa['id'], $semester, $tahunAjaran);
            $predikat = getPredikat($rataRata);

            // Cek apakah rapor sudah ada
            $existing = $this->raporModel->findBySiswaSemester($siswa['id'], $semester, $tahunAjaran);

            if ($existing) {
                // Update rata-rata saja, jangan ubah status verified
                $this->raporModel->update($existing['id'], [
                    'rata_rata' => $rataRata,
                    'predikat'  => $predikat,
                ]);
            } else {
                $this->raporModel->create([
                    'siswa_id'     => $siswa['id'],
                    'semester'     => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'rata_rata'    => $rataRata,
                    'predikat'     => $predikat,
                    'status'       => 'draft',
                ]);
            }
            $count++;
        }

        setFlash('success', "Rapor berhasil digenerate untuk {$count} siswa.");
        redirect(BASE_URL . '/index.php?page=rapor&semester=' . urlencode($semester) . '&tahun_ajaran=' . urlencode($tahunAjaran));
    }

    /**
     * Verifikasi rapor (khusus Kepala Sekolah)
     */
    public function verify($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        if (!in_array(currentRole(), ['admin', 'kepala_sekolah'])) {
            setFlash('error', 'Hanya Kepala Sekolah yang dapat memverifikasi rapor.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        $rapor = $this->raporModel->find($id);
        if (!$rapor) {
            setFlash('error', 'Rapor tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=rapor');
        }

        $newStatus = ($rapor['status'] === 'verified') ? 'draft' : 'verified';

        $this->raporModel->update($id, [
            'status'      => $newStatus,
            'verified_by' => $newStatus === 'verified' ? $_SESSION['user_id'] : null,
            'verified_at' => $newStatus === 'verified' ? date('Y-m-d H:i:s') : null,
        ]);

        $msg = $newStatus === 'verified' ? 'Rapor berhasil diverifikasi.' : 'Status rapor dikembalikan ke draft.';
        setFlash('success', $msg);
        redirect(BASE_URL . '/index.php?page=rapor');
    }
}
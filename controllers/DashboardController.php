<?php
// ============================================
// Controller Dashboard
// ============================================

class DashboardController
{
    private $siswaModel;
    private $userModel;
    private $nilaiModel;
    private $kehadiranModel;
    private $raporModel;

    public function __construct()
    {
        $this->siswaModel     = new Siswa();
        $this->userModel      = new User();
        $this->nilaiModel     = new Nilai();
        $this->kehadiranModel = new Kehadiran();
        $this->raporModel     = new Rapor();
    }

    public function index()
    {
        $role = currentRole();

        // Data statistik umum
        $data['totalSiswa']     = $this->siswaModel->count();
        $data['totalGuru']      = $this->userModel->countByRole('guru');
        $data['kehadiranHariIni'] = $this->kehadiranModel->getTodaySummary();

        // Rata-rata nilai keseluruhan
        $avgResult = $this->nilaiModel->queryOne(
            "SELECT AVG(nilai_angka) as avg_nilai FROM nilai WHERE semester = 'Ganjil' AND tahun_ajaran = '2024/2025'"
        );
        $data['rataRataNilai'] = $avgResult ? round($avgResult['avg_nilai'], 1) : 0;

        // Distribusi nilai
        $data['distribusi'] = $this->nilaiModel->getDistribusi('Ganjil', '2024/2025');

        // Daftar kelas
        $data['kelasList'] = $this->siswaModel->getKelasList();

        // Jumlah siswa per kelas
        $data['siswaPerKelas'] = [];
        foreach ($data['kelasList'] as $kelas) {
            $data['siswaPerKelas'][$kelas] = $this->siswaModel->countByKelas($kelas);
        }

        // Rata-rata per kelas (chart data)
        $data['rataPerKelas'] = [];
        foreach ($data['kelasList'] as $kelas) {
            $result = $this->nilaiModel->queryOne(
                "SELECT AVG(n.nilai_angka) as avg_nilai
                 FROM nilai n
                 JOIN siswa s ON n.siswa_id = s.id
                 WHERE s.kelas = ? AND n.semester = 'Ganjil' AND n.tahun_ajaran = '2024/2025'",
                [$kelas]
            );
            $data['rataPerKelas'][$kelas] = $result ? round($result['avg_nilai'], 1) : 0;
        }

        // Stats rapor (khusus admin & kepsek)
        if (in_array($role, ['admin', 'kepala_sekolah'])) {
            $data['raporStats'] = $this->raporModel->getStats('2024/2025');
        }

        // Aktivitas terbaru: 5 kehadiran terakhir
        $data['recentAttendance'] = $this->kehadiranModel->query(
            "SELECT k.*, s.nama as siswa_nama, s.kelas
             FROM kehadiran k
             JOIN siswa s ON k.siswa_id = s.id
             ORDER BY k.created_at DESC
             LIMIT 5"
        );

        $viewFile = __DIR__ . '/../views/dashboard/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }
}
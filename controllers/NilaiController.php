<?php
// ============================================
// Controller Nilai
// ============================================

class NilaiController
{
    private $nilaiModel;
    private $siswaModel;
    private $mapelModel;

    public function __construct()
    {
        $this->nilaiModel = new Nilai();
        $this->siswaModel = new Siswa();
        $this->mapelModel = new Mapel();
    }

    public function index()
    {
        $filterKelas = $_GET['kelas'] ?? '';
        $semester    = $_GET['semester'] ?? 'Ganjil';
        $tahunAjaran = $_GET['tahun_ajaran'] ?? '2024/2025';

        $data['semester']     = $semester;
        $data['tahunAjaran']  = $tahunAjaran;
        $data['kelasList']    = $this->siswaModel->getKelasList();
        $data['filterKelas']  = $filterKelas;
        $data['mapelList']    = $this->mapelModel->all('nama_mapel ASC');

        // Ambil nilai berdasarkan filter
        if ($filterKelas) {
            $sql = "SELECT n.*, s.nama as siswa_nama, s.nis, s.kelas, m.nama_mapel, m.kode
                    FROM nilai n
                    JOIN siswa s ON n.siswa_id = s.id
                    JOIN mapel m ON n.mapel_id = m.id
                    WHERE s.kelas = ? AND n.semester = ? AND n.tahun_ajaran = ?
                    ORDER BY s.nama ASC, m.nama_mapel ASC";
            $data['nilai'] = $this->nilaiModel->query($sql, [$filterKelas, $semester, $tahunAjaran]);
        } else {
            $data['nilai'] = [];
        }

        $viewFile = __DIR__ . '/../views/nilai/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function create()
    {
        $data['kelasList']   = $this->siswaModel->getKelasList();
        $data['mapelList']   = $this->mapelModel->all('nama_mapel ASC');
        $data['isEdit']      = false;
        $data['siswaList']   = [];
        $data['existingNilai'] = [];

        $viewFile = __DIR__ . '/../views/nilai/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function store()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=nilai&action=create');
        }

        $kelas       = $_POST['kelas'] ?? '';
        $mapelId     = $_POST['mapel_id'] ?? '';
        $semester    = $_POST['semester'] ?? 'Ganjil';
        $tahunAjaran = $_POST['tahun_ajaran'] ?? '2024/2025';
        $nilaiInput  = $_POST['nilai'] ?? [];

        if (empty($kelas) || empty($mapelId) || empty($nilaiInput)) {
            setFlash('error', 'Kelas, mata pelajaran, dan nilai wajib diisi.');
            redirect(BASE_URL . '/index.php?page=nilai&action=create');
        }

        $count = 0;
        foreach ($nilaiInput as $siswaId => $nilaiAngka) {
            if ($nilaiAngka !== '' && is_numeric($nilaiAngka)) {
                $nilaiAngka = max(0, min(100, (float)$nilaiAngka));
                $this->nilaiModel->upsert($siswaId, $mapelId, $nilaiAngka, $semester, $tahunAjaran);
                $count++;
            }
        }

        setFlash('success', "Nilai berhasil disimpan untuk {$count} siswa.");
        redirect(BASE_URL . '/index.php?page=nilai');
    }

    public function bulk()
    {
        // Alternatif endpoint untuk bulk save via AJAX (tidak digunakan di UI saat ini)
        $this->store();
    }
}
<?php
// ============================================
// Controller Kehadiran
// ============================================

class KehadiranController
{
    private $kehadiranModel;
    private $siswaModel;

    public function __construct()
    {
        $this->kehadiranModel = new Kehadiran();
        $this->siswaModel     = new Siswa();
    }

    public function index()
    {
        $filterKelas = $_GET['kelas'] ?? '';
        $tanggal     = $_GET['tanggal'] ?? date('Y-m-d');

        $data['kelasList']   = $this->siswaModel->getKelasList();
        $data['filterKelas'] = $filterKelas;
        $data['tanggal']     = $tanggal;

        if ($filterKelas && $tanggal) {
            $data['kehadiran'] = $this->kehadiranModel->getTodayByKelas($filterKelas, $tanggal);
        } else {
            $data['kehadiran'] = [];
        }

        $viewFile = __DIR__ . '/../views/kehadiran/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function create()
    {
        $data['kelasList'] = $this->siswaModel->getKelasList();
        $data['siswaList'] = [];
        $data['tanggal']   = date('Y-m-d');
        $viewFile = __DIR__ . '/../views/kehadiran/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function store()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=kehadiran&action=create');
        }

        $kelas      = $_POST['kelas'] ?? '';
        $tanggal    = $_POST['tanggal'] ?? date('Y-m-d');
        $statusList = $_POST['status'] ?? [];
        $ketList    = $_POST['keterangan'] ?? [];

        if (empty($kelas) || empty($tanggal)) {
            setFlash('error', 'Kelas dan tanggal wajib diisi.');
            redirect(BASE_URL . '/index.php?page=kehadiran&action=create');
        }

        $count = 0;
        foreach ($statusList as $siswaId => $status) {
            $keterangan = $ketList[$siswaId] ?? '';
            $this->kehadiranModel->saveAttendance($siswaId, $tanggal, $status, $keterangan);
            $count++;
        }

        setFlash('success', "Kehadiran berhasil disimpan untuk {$count} siswa.");
        redirect(BASE_URL . '/index.php?page=kehadiran&kelas=' . urlencode($kelas) . '&tanggal=' . urlencode($tanggal));
    }
}
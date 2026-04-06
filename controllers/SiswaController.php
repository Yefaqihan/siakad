<?php
// ============================================
// Controller Siswa (CRUD)
// ============================================

class SiswaController
{
    private $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new Siswa();
    }

    public function index()
    {
        $keyword = $_GET['q'] ?? '';
        $filterKelas = $_GET['kelas'] ?? '';

        if ($keyword) {
            $data['siswa'] = $this->siswaModel->search($keyword);
            $data['search'] = $keyword;
        } elseif ($filterKelas) {
            $data['siswa'] = $this->siswaModel->getByKelas($filterKelas);
            $data['filterKelas'] = $filterKelas;
        } else {
            $data['siswa'] = $this->siswaModel->all('kelas ASC, nama ASC');
        }

        $data['kelasList'] = $this->siswaModel->getKelasList();
        $viewFile = __DIR__ . '/../views/siswa/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function create()
    {
        $data['siswa'] = null;
        $data['isEdit'] = false;
        $viewFile = __DIR__ . '/../views/siswa/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function store()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=siswa&action=create');
        }

        $nama  = trim($_POST['nama'] ?? '');
        $nis   = trim($_POST['nis'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $jk    = $_POST['jenis_kelamin'] ?? 'L';

        // Validasi
        $errors = [];
        if (empty($nama)) $errors[] = 'Nama wajib diisi.';
        if (empty($nis))  $errors[] = 'NIS wajib diisi.';
        if (empty($kelas)) $errors[] = 'Kelas wajib diisi.';
        if ($this->siswaModel->findByNis($nis)) $errors[] = 'NIS sudah terdaftar.';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect(BASE_URL . '/index.php?page=siswa&action=create');
        }

        $this->siswaModel->create([
            'nama'          => $nama,
            'nis'           => $nis,
            'kelas'         => $kelas,
            'jenis_kelamin' => $jk,
        ]);

        setFlash('success', 'Data siswa berhasil ditambahkan.');
        redirect(BASE_URL . '/index.php?page=siswa');
    }

    public function edit($id)
    {
        $data['siswa'] = $this->siswaModel->find($id);
        if (!$data['siswa']) {
            setFlash('error', 'Data siswa tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=siswa');
        }
        $data['isEdit'] = true;
        $viewFile = __DIR__ . '/../views/siswa/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function update($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=siswa&action=edit&id=' . $id);
        }

        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            setFlash('error', 'Data siswa tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=siswa');
        }

        $nama  = trim($_POST['nama'] ?? '');
        $nis   = trim($_POST['nis'] ?? '');
        $kelas = trim($_POST['kelas'] ?? '');
        $jk    = $_POST['jenis_kelamin'] ?? 'L';

        $errors = [];
        if (empty($nama)) $errors[] = 'Nama wajib diisi.';
        if (empty($nis))  $errors[] = 'NIS wajib diisi.';
        if (empty($kelas)) $errors[] = 'Kelas wajib diisi.';

        // Cek NIS duplikat (kecuali siswa ini sendiri)
        $existing = $this->siswaModel->findByNis($nis);
        if ($existing && $existing['id'] != $id) {
            $errors[] = 'NIS sudah digunakan siswa lain.';
        }

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect(BASE_URL . '/index.php?page=siswa&action=edit&id=' . $id);
        }

        $this->siswaModel->update($id, [
            'nama'          => $nama,
            'nis'           => $nis,
            'kelas'         => $kelas,
            'jenis_kelamin' => $jk,
        ]);

        setFlash('success', 'Data siswa berhasil diperbarui.');
        redirect(BASE_URL . '/index.php?page=siswa');
    }

    public function delete($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=siswa');
        }

        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            setFlash('error', 'Data siswa tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=siswa');
        }

        $this->siswaModel->delete($id);
        setFlash('success', 'Data siswa berhasil dihapus.');
        redirect(BASE_URL . '/index.php?page=siswa');
    }
}
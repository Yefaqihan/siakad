<?php
// ============================================
// Controller Materi
// ============================================

class MateriController
{
    private $materiModel;
    private $mapelModel;

    public function __construct()
    {
        $this->materiModel = new Materi();
        $this->mapelModel  = new Mapel();
    }

    public function index()
    {
        $role  = currentRole();
        $userId = $_SESSION['user_id'];

        if ($role === 'guru') {
            $data['materi'] = $this->materiModel->getByGuru($userId);
        } else {
            $data['materi'] = $this->materiModel->getWithDetails();
        }

        $viewFile = __DIR__ . '/../views/materi/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function create()
    {
        $data['materi']   = null;
        $data['isEdit']   = false;
        $data['mapelList'] = $this->mapelModel->all('nama_mapel ASC');
        $viewFile = __DIR__ . '/../views/materi/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function store()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=materi&action=create');
        }

        $judul      = trim($_POST['judul'] ?? '');
        $deskripsi  = trim($_POST['deskripsi'] ?? '');
        $mapelId    = $_POST['mapel_id'] ?? null;
        $filePath   = null;

        if (empty($judul)) {
            setFlash('error', 'Judul materi wajib diisi.');
            redirect(BASE_URL . '/index.php?page=materi&action=create');
        }

        // Handle file upload
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'png', 'zip', 'rar'];
            $maxSize = 10 * 1024 * 1024; // 10MB

            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                setFlash('error', 'Tipe file tidak diperbolehkan. Gunakan: ' . implode(', ', $allowed));
                redirect(BASE_URL . '/index.php?page=materi&action=create');
            }
            if ($_FILES['file']['size'] > $maxSize) {
                setFlash('error', 'Ukuran file maksimal 10MB.');
                redirect(BASE_URL . '/index.php?page=materi&action=create');
            }

            $fileName = uniqid('materi_') . '.' . $ext;
            $uploadPath = UPLOAD_DIR . $fileName;

            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0755, true);
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                $filePath = $fileName;
            }
        }

        $this->materiModel->create([
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'file_path' => $filePath,
            'guru_id'   => $_SESSION['user_id'],
            'mapel_id'  => $mapelId ?: null,
        ]);

        setFlash('success', 'Materi berhasil ditambahkan.');
        redirect(BASE_URL . '/index.php?page=materi');
    }

    public function edit($id)
    {
        $data['materi'] = $this->materiModel->find($id);
        if (!$data['materi']) {
            setFlash('error', 'Materi tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=materi');
        }
        $data['isEdit']    = true;
        $data['mapelList'] = $this->mapelModel->all('nama_mapel ASC');
        $viewFile = __DIR__ . '/../views/materi/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function update($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=materi&action=edit&id=' . $id);
        }

        $materi = $this->materiModel->find($id);
        if (!$materi) {
            setFlash('error', 'Materi tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=materi');
        }

        $judul     = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $mapelId   = $_POST['mapel_id'] ?? null;

        if (empty($judul)) {
            setFlash('error', 'Judul materi wajib diisi.');
            redirect(BASE_URL . '/index.php?page=materi&action=edit&id=' . $id);
        }

        $updateData = [
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'mapel_id'  => $mapelId ?: null,
        ];

        // Handle file upload baru
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'png', 'zip', 'rar'];
            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $fileName = uniqid('materi_') . '.' . $ext;
                $uploadPath = UPLOAD_DIR . $fileName;
                if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                    // Hapus file lama
                    if ($materi['file_path'] && file_exists(UPLOAD_DIR . $materi['file_path'])) {
                        unlink(UPLOAD_DIR . $materi['file_path']);
                    }
                    $updateData['file_path'] = $fileName;
                }
            }
        }

        $this->materiModel->update($id, $updateData);
        setFlash('success', 'Materi berhasil diperbarui.');
        redirect(BASE_URL . '/index.php?page=materi');
    }

    public function delete($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=materi');
        }

        $materi = $this->materiModel->find($id);
        if ($materi) {
            // Hapus file
            if ($materi['file_path'] && file_exists(UPLOAD_DIR . $materi['file_path'])) {
                unlink(UPLOAD_DIR . $materi['file_path']);
            }
            $this->materiModel->delete($id);
        }

        setFlash('success', 'Materi berhasil dihapus.');
        redirect(BASE_URL . '/index.php?page=materi');
    }
}
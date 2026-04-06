<?php
// ============================================
// Controller User (Admin Only)
// ============================================

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $filterRole = $_GET['role'] ?? '';
        $data['users'] = $filterRole
            ? $this->userModel->getByRole($filterRole)
            : $this->userModel->all('nama ASC');
        $data['filterRole'] = $filterRole;

        $viewFile = __DIR__ . '/../views/users/index.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function create()
    {
        $data['user']   = null;
        $data['isEdit'] = false;
        $viewFile = __DIR__ . '/../views/users/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function store()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=users&action=create');
        }

        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'guru';

        $errors = [];
        if (empty($nama))     $errors[] = 'Nama wajib diisi.';
        if (empty($email))    $errors[] = 'Email wajib diisi.';
        if (empty($password)) $errors[] = 'Password wajib diisi.';
        if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter.';
        if ($this->userModel->findByEmail($email)) $errors[] = 'Email sudah terdaftar.';

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect(BASE_URL . '/index.php?page=users&action=create');
        }

        $this->userModel->create([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => $role,
        ]);

        setFlash('success', 'Pengguna berhasil ditambahkan.');
        redirect(BASE_URL . '/index.php?page=users');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        if (!$data['user']) {
            setFlash('error', 'Pengguna tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=users');
        }
        $data['isEdit'] = true;
        $viewFile = __DIR__ . '/../views/users/form.php';
        include __DIR__ . '/../views/layouts/dashboard.php';
    }

    public function update($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=users&action=edit&id=' . $id);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            setFlash('error', 'Pengguna tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=users');
        }

        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'guru';

        $errors = [];
        if (empty($nama))  $errors[] = 'Nama wajib diisi.';
        if (empty($email)) $errors[] = 'Email wajib diisi.';

        $existing = $this->userModel->findByEmail($email);
        if ($existing && $existing['id'] != $id) {
            $errors[] = 'Email sudah digunakan pengguna lain.';
        }

        if (!empty($errors)) {
            setFlash('error', implode('<br>', $errors));
            redirect(BASE_URL . '/index.php?page=users&action=edit&id=' . $id);
        }

        $updateData = [
            'nama'  => $nama,
            'email' => $email,
            'role'  => $role,
        ];

        // Update password hanya jika diisi
        if (!empty($password)) {
            if (strlen($password) < 6) {
                setFlash('error', 'Password minimal 6 karakter.');
                redirect(BASE_URL . '/index.php?page=users&action=edit&id=' . $id);
            }
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);
        setFlash('success', 'Pengguna berhasil diperbarui.');
        redirect(BASE_URL . '/index.php?page=users');
    }

    public function delete($id)
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid.');
            redirect(BASE_URL . '/index.php?page=users');
        }

        // Cegah hapus diri sendiri
        if ($id == $_SESSION['user_id']) {
            setFlash('error', 'Anda tidak dapat menghapus akun sendiri.');
            redirect(BASE_URL . '/index.php?page=users');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            setFlash('error', 'Pengguna tidak ditemukan.');
            redirect(BASE_URL . '/index.php?page=users');
        }

        $this->userModel->delete($id);
        setFlash('success', 'Pengguna berhasil dihapus.');
        redirect(BASE_URL . '/index.php?page=users');
    }
}
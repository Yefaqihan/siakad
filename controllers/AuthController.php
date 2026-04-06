<?php
// ============================================
// Controller Autentikasi
// ============================================

class AuthController
{
    public static function login()
    {
        if (!verifyCsrf()) {
            setFlash('error', 'Token keamanan tidak valid. Silakan coba lagi.');
            redirect(BASE_URL . '/index.php?page=login');
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            setFlash('error', 'Email dan password wajib diisi.');
            redirect(BASE_URL . '/index.php?page=login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            setFlash('error', 'Email atau password salah.');
            redirect(BASE_URL . '/index.php?page=login');
        }

        // Set session
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['nama'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role']  = $user['role'];

        setFlash('success', 'Selamat datang, ' . e($user['nama']) . '!');
        redirect(BASE_URL . '/index.php?page=dashboard');
    }
}
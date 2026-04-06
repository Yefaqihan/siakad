<?php
// ============================================
// Middleware Autentikasi & Autorisasi
// ============================================

// Peta hak akses berdasarkan role
 $rolePermissions = [
    'admin'          => ['dashboard', 'siswa', 'nilai', 'kehadiran', 'materi', 'rapor', 'users'],
    'guru'           => ['dashboard', 'nilai', 'kehadiran', 'materi', 'rapor'],
    'kepala_sekolah' => ['dashboard', 'nilai', 'kehadiran', 'materi', 'rapor'],
];

// Halaman yang tidak memerlukan autentikasi
 $publicPages = ['login', 'logout'];

/**
 * Cek apakah user sudah login
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Ambil data user yang sedang login
 */
function currentUser()
{
    if (!isLoggedIn()) return null;

    static $user = null;
    if ($user === null) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
    return $user;
}

/**
 * Cek role user yang sedang login
 */
function currentRole()
{
    return $_SESSION['user_role'] ?? null;
}

/**
 * Wajib login, jika belum redirect ke halaman login
 */
function requireLogin()
{
    if (!isLoggedIn()) {
        setFlash('error', 'Anda harus login terlebih dahulu.');
        redirect(BASE_URL . '/index.php?page=login');
    }
}

/**
 * Cek apakah role saat ini memiliki akses ke halaman tertentu
 */
function hasPermission($page, $role = null)
{
    global $rolePermissions;
    $role = $role ?: currentRole();
    if (!$role) return false;
    return in_array($page, $rolePermissions[$role] ?? []);
}

/**
 * Wajib memiliki permission, jika tidak redirect ke dashboard
 */
function requirePermission($page)
{
    if (!hasPermission($page)) {
        setFlash('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        redirect(BASE_URL . '/index.php?page=dashboard');
    }
}
<?php
// ============================================
// Router Utama SIAS
// Entry point seluruh aplikasi
// ============================================

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/middleware/auth.php';

// Peta halaman ke controller
 $controllerMap = [
    'dashboard' => 'DashboardController',
    'siswa'     => 'SiswaController',
    'nilai'     => 'NilaiController',
    'kehadiran' => 'KehadiranController',
    'materi'    => 'MateriController',
    'rapor'     => 'RaporController',
    'users'     => 'UserController',
];

 $page   = $_GET['page'] ?? 'login';
 $action = $_GET['action'] ?? 'index';
 $id     = $_GET['id'] ?? null;

// --- Handle Logout ---
if ($page === 'logout') {
    session_destroy();
    redirect(BASE_URL . '/index.php?page=login');
    exit;
}

// --- Handle Login POST ---
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/models/BaseModel.php';
    require_once __DIR__ . '/models/User.php';
    require_once __DIR__ . '/controllers/AuthController.php';
    AuthController::login();
    exit;
}

// --- Halaman Login (publik) ---
if ($page === 'login') {
    if (isLoggedIn()) {
        redirect(BASE_URL . '/index.php?page=dashboard');
    }
    require_once __DIR__ . '/views/login.php';
    exit;
}

// --- Semua halaman selanjutnya butuh login ---
requireLogin();

// --- Cek permission ---
if (isset($controllerMap[$page])) {
    requirePermission($page);
}

// --- Dispatch ke Controller ---
if (isset($controllerMap[$page])) {
    require_once __DIR__ . '/models/BaseModel.php';
    require_once __DIR__ . '/models/User.php';
    require_once __DIR__ . '/models/Siswa.php';
    require_once __DIR__ . '/models/Mapel.php';
    require_once __DIR__ . '/models/Nilai.php';
    require_once __DIR__ . '/models/Kehadiran.php';
    require_once __DIR__ . '/models/Materi.php';
    require_once __DIR__ . '/models/Rapor.php';

    require_once __DIR__ . '/controllers/' . $controllerMap[$page] . '.php';

    $controller = new $controllerMap[$page]();

    // Handle POST actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($action) {
            case 'store':  $controller->store();  break;
            case 'update': $controller->update($id); break;
            case 'delete': $controller->delete($id); break;
            case 'verify': $controller->verify($id); break;
            case 'bulk':   $controller->bulk();   break;
            default:       $controller->index();   break;
        }
    } else {
        switch ($action) {
            case 'create': $controller->create();  break;
            case 'edit':   $controller->edit($id); break;
            case 'detail': $controller->detail($id); break;
            default:       $controller->index();   break;
        }
    }
} else {
    // Halaman tidak ditemukan
    http_response_code(404);
    echo '<h1>404 - Halaman Tidak Ditemukan</h1>';
    echo '<a href="' . BASE_URL . '/index.php?page=dashboard">Kembali ke Dashboard</a>';
}
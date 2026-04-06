<?php
// ============================================
// Konfigurasi Aplikasi & Helper Functions
// ============================================

define('APP_NAME', 'SIAS');
define('APP_FULL_NAME', 'Sistem Informasi Akademik Sekolah');
define('APP_VERSION', '1.0.0');
define('BASE_URL', '/sias'); // Sesuaikan dengan folder project Anda
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', BASE_URL . '/assets/uploads/');

// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Helper: Redirect ---
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

// --- Helper: Flash Message ---
function setFlash($type, $message)
{
    $_SESSION['flash'][$type] = $message;
}

function getFlash($type)
{
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}

function hasFlash($type)
{
    return isset($_SESSION['flash'][$type]);
}

// --- Helper: CSRF Token ---
function csrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField()
{
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

function verifyCsrf()
{
    $token = $_POST['csrf_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

// --- Helper: Sanitasi Output ---
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// --- Helper: Format Tanggal ---
function formatTanggal($tanggal)
{
    if (!$tanggal) return '-';
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $dt = new DateTime($tanggal);
    return $dt->format('d') . ' ' . $bulan[(int)$dt->format('m')] . ' ' . $dt->format('Y');
}

// --- Helper: Predikat Nilai ---
function getPredikat($nilai)
{
    if ($nilai >= 90) return 'A';
    if ($nilai >= 80) return 'B';
    if ($nilai >= 70) return 'C';
    if ($nilai >= 60) return 'D';
    return 'E';
}

// --- Helper: Badge Status Kehadiran ---
function badgeKehadiran($status)
{
    $map = [
        'hadir' => '<span class="badge bg-success-subtle text-success">Hadir</span>',
        'izin'  => '<span class="badge bg-info-subtle text-info">Izin</span>',
        'sakit' => '<span class="badge bg-warning-subtle text-warning">Sakit</span>',
        'alfa'  => '<span class="badge bg-danger-subtle text-danger">Alfa</span>',
    ];
    return $map[$status] ?? $status;
}

// --- Helper: Badge Status Rapor ---
function badgeRapor($status)
{
    $map = [
        'draft'    => '<span class="badge bg-warning-subtle text-warning">Draft</span>',
        'verified' => '<span class="badge bg-success-subtle text-success">Terverifikasi</span>',
    ];
    return $map[$status] ?? $status;
}

// --- Helper: Role Label ---
function roleLabel($role)
{
    $map = [
        'admin'         => '<span class="badge bg-primary">Admin</span>',
        'guru'          => '<span class="badge bg-info">Guru</span>',
        'kepala_sekolah'=> '<span class="badge bg-dark">Kepala Sekolah</span>',
    ];
    return $map[$role] ?? $role;
}
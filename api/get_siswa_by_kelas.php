<?php
// ============================================
// API: Ambil daftar siswa berdasarkan kelas
// Digunakan oleh form Nilai & Kehadiran (AJAX)
// ============================================

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/Siswa.php';

header('Content-Type: application/json');

 $kelas = $_GET['kelas'] ?? '';

if (empty($kelas)) {
    http_response_code(400);
    echo json_encode(['error' => 'Parameter kelas diperlukan.']);
    exit;
}

 $siswaModel = new Siswa();
 $result = $siswaModel->getByKelas($kelas);

echo json_encode($result);
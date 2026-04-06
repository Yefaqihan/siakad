<?php
// ============================================
// Model Kehadiran
// ============================================

class Kehadiran extends BaseModel
{
    protected $table = 'kehadiran';

    /**
     * Ambil kehadiran hari ini untuk kelas tertentu
     */
    public function getTodayByKelas($kelas, $tanggal = null)
    {
        $tanggal = $tanggal ?: date('Y-m-d');
        $sql = "SELECT k.*, s.nama, s.nis, s.kelas
                FROM {$this->table} k
                JOIN siswa s ON k.siswa_id = s.id
                WHERE s.kelas = ? AND k.tanggal = ?
                ORDER BY s.nama ASC";
        return $this->query($sql, [$kelas, $tanggal]);
    }

    /**
     * Rekap kehadiran siswa per semester
     */
    public function getRekap($siswaId, $semester, $tahunAjaran)
    {
        // Tentukan rentang tanggal berdasarkan semester
        $tahun = explode('/', $tahunAjaran)[0];
        if ($semester === 'Ganjil') {
            $mulai = "{$tahun}-07-01";
            $selesai = "{$tahun}-12-31";
        } else {
            $thn2 = explode('/', $tahunAjaran)[1] ?? $tahun;
            $mulai = "{$thn2}-01-01";
            $selesai = "{$thn2}-06-30";
        }

        $sql = "SELECT
                    SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa,
                    COUNT(*) as total
                FROM {$this->table}
                WHERE siswa_id = ? AND tanggal BETWEEN ? AND ?";
        return $this->queryOne($sql, [$siswaId, $mulai, $selesai]);
    }

    /**
     * Rekap kehadiran hari ini keseluruhan
     */
    public function getTodaySummary()
    {
        $today = date('Y-m-d');
        $sql = "SELECT
                    SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa,
                    COUNT(*) as total
                FROM {$this->table}
                WHERE tanggal = ?";
        return $this->queryOne($sql, [$today]);
    }

    /**
     * Simpan kehadiran per siswa (upsert)
     */
    public function saveAttendance($siswaId, $tanggal, $status, $keterangan = null)
    {
        // Cek apakah sudah ada
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE siswa_id = ? AND tanggal = ?";
        $result = $this->queryOne($sql, [$siswaId, $tanggal]);

        if ((int)$result['total'] > 0) {
            $sql2 = "UPDATE {$this->table} SET status = ?, keterangan = ? WHERE siswa_id = ? AND tanggal = ?";
            return $this->query($sql2, [$status, $keterangan, $siswaId, $tanggal]);
        } else {
            return $this->create([
                'siswa_id'   => $siswaId,
                'tanggal'    => $tanggal,
                'status'     => $status,
                'keterangan' => $keterangan,
            ]);
        }
    }
}
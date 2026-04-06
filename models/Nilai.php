<?php
// ============================================
// Model Nilai
// ============================================

class Nilai extends BaseModel
{
    protected $table = 'nilai';

    /**
     * Ambil nilai siswa tertentu per semester
     */
    public function getBySiswaSemester($siswaId, $semester, $tahunAjaran)
    {
        $sql = "SELECT n.*, m.nama_mapel, m.kode
                FROM {$this->table} n
                JOIN mapel m ON n.mapel_id = m.id
                WHERE n.siswa_id = ? AND n.semester = ? AND n.tahun_ajaran = ?
                ORDER BY m.nama_mapel ASC";
        return $this->query($sql, [$siswaId, $semester, $tahunAjaran]);
    }

    /**
     * Hitung rata-rata nilai siswa per semester
     */
    public function getRataRata($siswaId, $semester, $tahunAjaran)
    {
        $sql = "SELECT AVG(nilai_angka) as rata_rata FROM {$this->table}
                WHERE siswa_id = ? AND semester = ? AND tahun_ajaran = ?";
        $result = $this->queryOne($sql, [$siswaId, $semester, $tahunAjaran]);
        return $result ? round($result['rata_rata'], 2) : 0;
    }

    /**
     * Cek apakah nilai sudah ada (untuk mencegah duplikat)
     */
    public function exists($siswaId, $mapelId, $semester, $tahunAjaran)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}
                WHERE siswa_id = ? AND mapel_id = ? AND semester = ? AND tahun_ajaran = ?";
        $result = $this->queryOne($sql, [$siswaId, $mapelId, $semester, $tahunAjaran]);
        return (int)$result['total'] > 0;
    }

    /**
     * Update atau insert nilai
     */
    public function upsert($siswaId, $mapelId, $nilaiAngka, $semester, $tahunAjaran)
    {
        if ($this->exists($siswaId, $mapelId, $semester, $tahunAjaran)) {
            $sql = "UPDATE {$this->table} SET nilai_angka = ? WHERE siswa_id = ? AND mapel_id = ? AND semester = ? AND tahun_ajaran = ?";
            return $this->query($sql, [$nilaiAngka, $siswaId, $mapelId, $semester, $tahunAjaran]);
        } else {
            return $this->create([
                'siswa_id'     => $siswaId,
                'mapel_id'     => $mapelId,
                'nilai_angka'  => $nilaiAngka,
                'semester'     => $semester,
                'tahun_ajaran' => $tahunAjaran,
            ]);
        }
    }

    /**
     * Distribusi nilai per kategori
     */
    public function getDistribusi($semester, $tahunAjaran)
    {
        $sql = "SELECT
                    SUM(CASE WHEN nilai_angka >= 90 THEN 1 ELSE 0 END) as 'A',
                    SUM(CASE WHEN nilai_angka >= 80 AND nilai_angka < 90 THEN 1 ELSE 0 END) as 'B',
                    SUM(CASE WHEN nilai_angka >= 70 AND nilai_angka < 80 THEN 1 ELSE 0 END) as 'C',
                    SUM(CASE WHEN nilai_angka >= 60 AND nilai_angka < 70 THEN 1 ELSE 0 END) as 'D',
                    SUM(CASE WHEN nilai_angka < 60 THEN 1 ELSE 0 END) as 'E'
                FROM {$this->table}
                WHERE semester = ? AND tahun_ajaran = ?";
        return $this->queryOne($sql, [$semester, $tahunAjaran]);
    }
}
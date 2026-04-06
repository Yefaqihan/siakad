<?php
// ============================================
// Model Rapor
// ============================================

class Rapor extends BaseModel
{
    protected $table = 'rapor';

    /**
     * Ambil rapor dengan info siswa
     */
    public function getWithSiswa($semester = null, $tahunAjaran = null)
    {
        $sql = "SELECT r.*, s.nama as siswa_nama, s.nis, s.kelas, u.nama as verified_name
                FROM {$this->table} r
                JOIN siswa s ON r.siswa_id = s.id
                LEFT JOIN users u ON r.verified_by = u.id
                WHERE 1=1";
        $params = [];

        if ($semester) {
            $sql .= " AND r.semester = ?";
            $params[] = $semester;
        }
        if ($tahunAjaran) {
            $sql .= " AND r.tahun_ajaran = ?";
            $params[] = $tahunAjaran;
        }

        $sql .= " ORDER BY s.kelas ASC, s.nama ASC";
        return $this->query($sql, $params);
    }

    /**
     * Cari rapor berdasarkan siswa dan semester
     */
    public function findBySiswaSemester($siswaId, $semester, $tahunAjaran)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE siswa_id = ? AND semester = ? AND tahun_ajaran = ?";
        return $this->queryOne($sql, [$siswaId, $semester, $tahunAjaran]);
    }

    /**
     * Hitung statistik rapor
     */
    public function getStats($tahunAjaran)
    {
        $sql = "SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                    AVG(rata_rata) as avg_rata
                FROM {$this->table}
                WHERE tahun_ajaran = ?";
        return $this->queryOne($sql, [$tahunAjaran]);
    }
}
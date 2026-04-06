<?php
// ============================================
// Model Siswa
// ============================================

class Siswa extends BaseModel
{
    protected $table = 'siswa';

    /**
     * Ambil daftar kelas yang tersedia
     */
    public function getKelasList()
    {
        $stmt = $this->db->query("SELECT DISTINCT kelas FROM {$this->table} ORDER BY kelas ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Ambil siswa berdasarkan kelas
     */
    public function getByKelas($kelas)
    {
        return $this->where('kelas', $kelas);
    }

    /**
     * Hitung siswa per kelas
     */
    public function countByKelas($kelas)
    {
        return $this->count('kelas', $kelas);
    }

    /**
     * Cari siswa berdasarkan NIS
     */
    public function findByNis($nis)
    {
        return $this->firstWhere('nis', $nis);
    }

    /**
     * Pencarian siswa (nama atau NIS)
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM {$this->table} WHERE nama LIKE ? OR nis LIKE ? ORDER BY kelas ASC, nama ASC";
        $param = "%{$keyword}%";
        return $this->query($sql, [$param, $param]);
    }
}
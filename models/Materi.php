<?php
// ============================================
// Model Materi
// ============================================

class Materi extends BaseModel
{
    protected $table = 'materi';

    /**
     * Ambil materi dengan info guru dan mapel
     */
    public function getWithDetails()
    {
        $sql = "SELECT m.*, u.nama as guru_nama, mp.nama_mapel
                FROM {$this->table} m
                JOIN users u ON m.guru_id = u.id
                LEFT JOIN mapel mp ON m.mapel_id = mp.id
                ORDER BY m.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Ambil materi berdasarkan guru
     */
    public function getByGuru($guruId)
    {
    $sql = "SELECT m.*, u.nama as guru_nama, mp.nama_mapel
            FROM {$this->table} m
            JOIN users u ON m.guru_id = u.id
            LEFT JOIN mapel mp ON m.mapel_id = mp.id
            WHERE m.guru_id = ?
            ORDER BY m.created_at DESC";
    return $this->query($sql, [$guruId]);
    }
}
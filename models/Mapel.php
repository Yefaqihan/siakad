<?php
// ============================================
// Model Mata Pelajaran
// ============================================

class Mapel extends BaseModel
{
    protected $table = 'mapel';

    /**
     * Cari berdasarkan kode
     */
    public function findByKode($kode)
    {
        return $this->firstWhere('kode', $kode);
    }
}
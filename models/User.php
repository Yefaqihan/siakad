<?php
// ============================================
// Model User
// ============================================

class User extends BaseModel
{
    protected $table = 'users';

    /**
     * Cari user berdasarkan email
     */
    public function findByEmail($email)
    {
        return $this->firstWhere('email', $email);
    }

    /**
     * Ambil semua guru
     */
    public function getGuru()
    {
        return $this->where('role', 'guru');
    }

    /**
     * Ambil user berdasarkan role (kecuali diri sendiri)
     */
    public function getByRole($role, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT * FROM {$this->table} WHERE role = ? AND id != ? ORDER BY nama ASC";
            return $this->query($sql, [$role, $excludeId]);
        }
        return $this->where('role', $role);
    }

    /**
     * Hitung user per role
     */
    public function countByRole($role)
    {
        return $this->count('role', $role);
    }
}
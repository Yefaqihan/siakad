<?php
// ============================================
// Base Model - CRUD Generik
// Semua model lain mewarisi kelas ini
// ============================================

class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = getDB();
    }

    /**
     * Ambil semua data
     */
    public function all($orderBy = 'id DESC')
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    /**
     * Ambil data berdasarkan ID
     */
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Ambil data dengan kondisi WHERE
     */
    public function where($column, $value, $operator = '=')
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} {$operator} ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    /**
     * Ambil satu data dengan kondisi WHERE
     */
    public function firstWhere($column, $value, $operator = '=')
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} {$operator} ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    /**
     * Hitung jumlah data
     */
    public function count($column = null, $value = null)
    {
        if ($column && $value) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE {$column} = ?");
            $stmt->execute([$value]);
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        }
        $result = $stmt->fetch();
        return (int)$result['total'];
    }

    /**
     * Insert data baru
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    /**
     * Update data berdasarkan ID
     */
    public function update($id, $data)
    {
        $set = implode(', ', array_map(function ($col) {
            return "{$col} = ?";
        }, array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$set} WHERE id = ?");
        return $stmt->execute($values);
    }

    /**
     * Hapus data berdasarkan ID
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Query custom dengan prepared statement
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Query custom, mengembalikan satu baris
     */
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
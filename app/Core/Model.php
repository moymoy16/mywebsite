<?php
namespace App\Core;

abstract class Model
{
    protected \PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::get();
    }

    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}
<?php
namespace App\Models;

use App\Core\Model;

class Item extends Model
{
    protected string $table = 'items';

    public function allActive(): array
    {
        return $this->db->query(
            "SELECT i.*, u.name AS created_by_name
             FROM {$this->table} i
             JOIN users u ON u.id = i.created_by
             WHERE i.status = 'active'
             ORDER BY i.created_at DESC"
        )->fetchAll();
    }

    public function createItem(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table}
             (name, category, description, image, total_stock, available_stock, created_by)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['name'],
            $data['category'],
            $data['description'] ?? null,
            $data['image'] ?? null,
            $data['total_stock'],
            $data['total_stock'],      // available = total on creation
            $data['created_by'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function updateItem(int $id, array $data): void
    {

        if (array_key_exists('image', $data) && $data['image'] !== null) {
            $stmt = $this->db->prepare(
                "UPDATE {$this->table}
                SET name = ?, category = ?, description = ?, total_stock = ?, image = ?
                WHERE id = ?"
            );
            $stmt->execute([
                $data['name'],
                $data['category'],
                $data['description'] ?? null,
                $data['total_stock'],
                $data['image'],
                $id,
            ]);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE {$this->table}
                SET name = ?, category = ?, description = ?, total_stock = ?
                WHERE id = ?"
            );
            $stmt->execute([
                $data['name'],
                $data['category'],
                $data['description'] ?? null,
                $data['total_stock'],
                $id,
            ]);
        }
    }

    public function archive(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = 'archived' WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function findActive(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ? AND status = 'active' LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function filterActive(?string $search = null, ?string $category = null): array
    {
        $sql    = "SELECT * FROM {$this->table} WHERE status = 'active'";
        $params = [];

        if ($search !== null && $search !== '') {
            $sql .= " AND name LIKE ?";
            $params[] = '%' . $search . '%';
        }
        if ($category !== null && $category !== '') {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function allCategories(): array
    {
        return $this->db->query(
            "SELECT DISTINCT category FROM {$this->table}
            WHERE status = 'active'
            ORDER BY category ASC"
        )->fetchAll(\PDO::FETCH_COLUMN);
    }

    // ═══ ADDED: used when admin approves a borrowing ═══
    public function decrementStock(int $id, int $qty): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
            SET available_stock = available_stock - ?
            WHERE id = ? AND available_stock >= ?"
        );
        $stmt->execute([$qty, $id, $qty]);
        return $stmt->rowCount() > 0;   // false if not enough stock
    }

    public function incrementStock(int $id, int $qty): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
            SET available_stock = available_stock + ?
            WHERE id = ? AND available_stock + ? <= total_stock"
        );
        $stmt->execute([$qty, $id, $qty]);
    }
    // ═══ END ADDED ═══   
    public function findByIds(array $ids): array
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
            WHERE id IN ($placeholders) AND status = 'active'"
        );
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }
}
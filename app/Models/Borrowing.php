<?php
namespace App\Models;

use App\Core\Model;

class Borrowing extends Model
{
    protected string $table = 'borrowings';

    // ═══ CREATE with items ═══
    public function createWithItems(int $studentId, array $items, string $borrowDate, string $dueDate): int
    {
        $this->db->beginTransaction();

        try {
            // 1. Create the borrowing row
            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table}
                 (student_id, borrow_date, due_date, status)
                 VALUES (?, ?, ?, 'pending')"
            );
            $stmt->execute([$studentId, $borrowDate, $dueDate]);
            $borrowingId = (int)$this->db->lastInsertId();

            // 2. Insert each item
            $itemStmt = $this->db->prepare(
                "INSERT INTO borrowing_items (borrowing_id, item_id, quantity)
                 VALUES (?, ?, ?)"
            );
            foreach ($items as $item) {
                $itemStmt->execute([$borrowingId, (int)$item['id'], (int)$item['quantity']]);
            }

            $this->db->commit();
            return $borrowingId;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // ═══ FETCH with items ═══
    public function findWithRelations(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*, u.name AS student_name, u.email AS student_email
             FROM {$this->table} b
             JOIN users u ON u.id = b.student_id
             WHERE b.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $borrowing = $stmt->fetch();
        if (!$borrowing) return null;

        $borrowing['items'] = $this->getItems($id);
        return $borrowing;
    }

    public function getItems(int $borrowingId): array
    {
        $stmt = $this->db->prepare(
            "SELECT bi.*, i.name AS item_name, i.category, i.image
             FROM borrowing_items bi
             JOIN items i ON i.id = bi.item_id
             WHERE bi.borrowing_id = ?"
        );
        $stmt->execute([$borrowingId]);
        return $stmt->fetchAll();
    }

    // ═══ LIST views ═══
    public function allWithRelations(?string $status = null): array
    {
        $sql = "SELECT b.*, u.name AS student_name, u.email AS student_email,
                       (SELECT COUNT(*) FROM borrowing_items WHERE borrowing_id = b.id) AS item_count,
                       (SELECT SUM(quantity) FROM borrowing_items WHERE borrowing_id = b.id) AS total_quantity
                FROM {$this->table} b
                JOIN users u ON u.id = b.student_id";

        $params = [];
        if ($status !== null && $status !== '') {
            $sql .= " WHERE b.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY b.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function forStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*,
                    (SELECT COUNT(*) FROM borrowing_items WHERE borrowing_id = b.id) AS item_count,
                    (SELECT SUM(quantity) FROM borrowing_items WHERE borrowing_id = b.id) AS total_quantity,
                    (SELECT i.name FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_name,
                    (SELECT i.image FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_image
             FROM {$this->table} b
             WHERE b.student_id = ?
             ORDER BY b.created_at DESC"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function activeForStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*,
                    (SELECT COUNT(*) FROM borrowing_items WHERE borrowing_id = b.id) AS item_count,
                    (SELECT SUM(quantity) FROM borrowing_items WHERE borrowing_id = b.id) AS total_quantity,
                    (SELECT i.name FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_name,
                    (SELECT i.image FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_image
             FROM {$this->table} b
             WHERE b.student_id = ?
               AND b.status IN ('approved', 'overdue')
             ORDER BY b.due_date ASC"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function recentForStudent(int $studentId, int $limit = 5): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*,
                    (SELECT COUNT(*) FROM borrowing_items WHERE borrowing_id = b.id) AS item_count,
                    (SELECT i.name FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_name
             FROM {$this->table} b
             WHERE b.student_id = ?
               AND b.status IN ('returned', 'rejected')
             ORDER BY b.updated_at DESC, b.id DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $studentId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function upcomingDueForStudent(int $studentId, int $days = 7): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*,
                    (SELECT i.name FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_name
             FROM {$this->table} b
             WHERE b.student_id = ?
               AND b.status = 'approved'
               AND b.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
             ORDER BY b.due_date ASC"
        );
        $stmt->bindValue(1, $studentId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $days, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ═══ STATUS helpers ═══
    public function setStatus(int $id, string $status, ?int $handledBy = null): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET status = ?, handled_by = ? WHERE id = ?"
        );
        $stmt->execute([$status, $handledBy, $id]);
    }

    public function markReturned(int $id): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET status = 'returned', returned_at = CURDATE() WHERE id = ?"
        );
        $stmt->execute([$id]);
    }

    public function markOverdue(): int
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET status = 'overdue'
             WHERE status = 'approved'
               AND due_date IS NOT NULL
               AND due_date < CURDATE()"
        );
        $stmt->execute();
        return $stmt->rowCount();
    }

    // ═══ Counts ═══
    public function countByStatus(string $status): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = ?"
        );
        $stmt->execute([$status]);
        return (int)$stmt->fetchColumn();
    }

    public function overdueCountForStudent(int $studentId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table}
             WHERE student_id = ? AND status = 'overdue'"
        );
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }

    public function pendingCount(): int
    {
        return $this->countByStatus('pending');
    }

    // ═══ Dashboard summary ═══
    public function studentSummary(int $studentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                SUM(status = 'pending')  AS pending,
                SUM(status = 'approved') AS approved,
                SUM(status = 'overdue')  AS overdue,
                SUM(status = 'returned') AS returned,
                COUNT(*)                 AS total
             FROM {$this->table}
             WHERE student_id = ?"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetch() ?: [];
    }

    // ═══ Stock helpers — operate on items ═══
    public function decrementStockForBorrowing(int $borrowingId): bool
    {
        $items = $this->getItems($borrowingId);
        $itemModel = new Item();

        $this->db->beginTransaction();
        try {
            foreach ($items as $item) {
                $ok = $itemModel->decrementStock((int)$item['item_id'], (int)$item['quantity']);
                if (!$ok) {
                    $this->db->rollBack();
                    return false;
                }
            }
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function incrementStockForBorrowing(int $borrowingId): void
    {
        $items = $this->getItems($borrowingId);
        $itemModel = new Item();

        foreach ($items as $item) {
            $itemModel->incrementStock((int)$item['item_id'], (int)$item['quantity']);
        }
    }
}
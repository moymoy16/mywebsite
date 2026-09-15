<?php
namespace App\Models;

use App\Core\Model;

class Borrowing extends Model
{
    protected string $table = 'borrowings';

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table}
             (student_id, item_id, quantity, borrow_date, due_date, status)
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $stmt->execute([
            $data['student_id'],
            $data['item_id'],
            $data['quantity'],
            $data['borrow_date'],
            $data['due_date'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function forStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*, i.name AS item_name, i.category
             FROM {$this->table} b
             JOIN items i ON i.id = b.item_id
             WHERE b.student_id = ?
             ORDER BY b.created_at DESC"
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public function allWithRelations(?string $status = null): array
    {
        $sql = "SELECT b.*, i.name AS item_name, u.name AS student_name, u.email AS student_email
                FROM {$this->table} b
                JOIN items i ON i.id = b.item_id
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

    public function findWithRelations(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*,
                    i.name AS item_name, i.category, i.available_stock,
                    u.name AS student_name, u.email AS student_email
             FROM {$this->table} b
             JOIN items i ON i.id = b.item_id
             JOIN users u ON u.id = b.student_id
             WHERE b.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function setStatus(int $id, string $status, ?int $handledBy = null): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET status = ?, handled_by = ?
             WHERE id = ?"
        );
        $stmt->execute([$status, $handledBy, $id]);
    }

    public function markReturned(int $id): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET status = 'returned', returned_at = CURDATE()
             WHERE id = ?"
        );
        $stmt->execute([$id]);
    }

    public function pendingCount(): int
    {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = 'pending'"
        )->fetchColumn();
    }
    // ═══ ADDED: auto-flip approved → overdue when past due ═══
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

    public function overdueCountForStudent(int $studentId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table}
            WHERE student_id = ? AND status = 'overdue'"
        );
        $stmt->execute([$studentId]);
        return (int)$stmt->fetchColumn();
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = ?"
        );
        $stmt->execute([$status]);
        return (int)$stmt->fetchColumn();
    }
    // ═══ END ADDED ═══
    // ═══ ADDED: student dashboard queries ═══
    public function activeForStudent(int $studentId): array
    {
        $stmt = $this->db->prepare(
            "SELECT b.*, i.name AS item_name, i.category, i.image
            FROM {$this->table} b
            JOIN items i ON i.id = b.item_id
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
            "SELECT b.*, i.name AS item_name, i.category
            FROM {$this->table} b
            JOIN items i ON i.id = b.item_id
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
            "SELECT b.*, i.name AS item_name
            FROM {$this->table} b
            JOIN items i ON i.id = b.item_id
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
// ═══ END ADDED ═══
}
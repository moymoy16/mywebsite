<?php
namespace App\Models;

use App\Core\Model;

class Contract extends Model
{
    protected string $table = 'contracts';

    public function createForBorrowing(int $borrowingId): int
    {
        $contractNo = 'CTR-' . date('Ymd') . '-' . str_pad((string)$borrowingId, 5, '0', STR_PAD_LEFT);

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (borrowing_id, contract_no, terms)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $borrowingId,
            $contractNo,
            'The borrower agrees to return the item in good condition on or before the due date.',
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function findByBorrowing(int $borrowingId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE borrowing_id = ? LIMIT 1"
        );
        $stmt->execute([$borrowingId]);
        return $stmt->fetch() ?: null;
    }

    // ═══ ADDED: full contract data with relations ═══
    public function findFull(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT c.*,
                    b.borrow_date, b.due_date, b.status AS borrowing_status,
                    u.name AS student_name, u.email AS student_email, u.student_id
            FROM {$this->table} c
            JOIN borrowings b ON b.id = c.borrowing_id
            JOIN users u ON u.id = b.student_id
            WHERE c.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $contract = $stmt->fetch();
        if (!$contract) return null;

        // Fetch items
        $itemStmt = $this->db->prepare(
            "SELECT bi.*, i.name AS item_name, i.category, i.description AS item_description
            FROM borrowing_items bi
            JOIN items i ON i.id = bi.item_id
            WHERE bi.borrowing_id = ?"
        );
        $itemStmt->execute([$contract['borrowing_id']]);
        $contract['items'] = $itemStmt->fetchAll();

        return $contract;
    }

    public function allWithRelations(): array
    {
        return $this->db->query(
            "SELECT c.*,
                    b.status AS borrowing_status, b.due_date,
                    u.name AS student_name,
                    (SELECT COUNT(*) FROM borrowing_items WHERE borrowing_id = b.id) AS item_count,
                    (SELECT i.name FROM borrowing_items bi
                        JOIN items i ON i.id = bi.item_id
                        WHERE bi.borrowing_id = b.id LIMIT 1) AS first_item_name
            FROM {$this->table} c
            JOIN borrowings b ON b.id = c.borrowing_id
            JOIN users u ON u.id = b.student_id
            ORDER BY c.created_at DESC"
        )->fetchAll();
    }

    public function markSigned(int $id): void
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET signed_at = NOW() WHERE id = ?"
        );
        $stmt->execute([$id]);
    }
    // ═══ END ADDED ═══
}
<?php
namespace App\Models;

use App\Core\Model;

class PasswordReset extends Model
{
    protected string $table = 'password_resets';

    public function createRequest(int $userId, ?string $note = null): int
    {
        // Cancel any existing pending request from the same user
        $this->db->prepare(
            "UPDATE {$this->table}
             SET status = 'expired'
             WHERE user_id = ? AND status = 'pending'"
        )->execute([$userId]);

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} (user_id, token_hash, expires_at, status, note)
             VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 7 DAY), 'pending', ?)"
        );
        $stmt->execute([$userId, bin2hex(random_bytes(8)), $note]);

        return (int)$this->db->lastInsertId();
    }

    public function pendingRequests(): array
    {
        return $this->db->query(
            "SELECT r.*, u.name AS user_name, u.email AS user_email, u.role
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.status = 'pending'
             ORDER BY r.created_at ASC"
        )->fetchAll();
    }

    public function allRequests(int $limit = 100): array
    {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.name AS user_name, u.email AS user_email, u.role,
                    a.name AS admin_name
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             LEFT JOIN users a ON a.id = r.resolved_by
             ORDER BY r.created_at DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.name AS user_name, u.email AS user_email
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.id = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function hasPendingRequest(int $userId): bool
    {
        $stmt = $this->db->prepare(
            "SELECT 1 FROM {$this->table}
             WHERE user_id = ? AND status = 'pending' LIMIT 1"
        );
        $stmt->execute([$userId]);
        return (bool)$stmt->fetchColumn();
    }

    public function markResolved(int $id, int $adminId): void
    {
        $this->db->prepare(
            "UPDATE {$this->table}
             SET status = 'resolved', resolved_by = ?, resolved_at = NOW()
             WHERE id = ?"
        )->execute([$adminId, $id]);
    }

    public function pendingCount(): int
    {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = 'pending'"
        )->fetchColumn();
    }
}
<?php
namespace App\Models;

use App\Core\Model;

class ProfileChangeRequest extends Model
{
    protected string $table = 'profile_change_requests';

    private array $allowedFields = [
        'name', 'email', 'student_id', 'section', 'gender', 'year_level', 'age'
    ];

    public function create(int $userId, array $fields, array $newValues, string $reason, ?string $proofImage): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table}
             (user_id, field_name, old_value, new_value, reason, proof_image)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        foreach ($fields as $field) {
            if (!in_array($field, $this->allowedFields, true)) continue;
            $stmt->execute([
                $userId,
                $field,
                $newValues[$field]['old'] ?? null,
                $newValues[$field]['new'] ?? '',
                $reason,
                $proofImage,
            ]);
        }
    }

    public function pending(): array
    {
        return $this->db->query(
            "SELECT r.*, u.name AS user_name, u.email AS user_email
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.status = 'pending'
             ORDER BY r.created_at ASC"
        )->fetchAll();
    }

    public function pendingGrouped(): array
    {
        $rows = $this->pending();
        $grouped = [];
        foreach ($rows as $r) {
            $key = $r['user_id'] . '|' . $r['created_at'];
            $grouped[$key]['user_id']    = $r['user_id'];
            $grouped[$key]['user_name']  = $r['user_name'];
            $grouped[$key]['user_email'] = $r['user_email'];
            $grouped[$key]['reason']     = $r['reason'];
            $grouped[$key]['proof_image']= $r['proof_image'];
            $grouped[$key]['created_at'] = $r['created_at'];
            $grouped[$key]['ids'][]      = $r['id'];
            $grouped[$key]['changes'][]  = [
                'field'     => $r['field_name'],
                'old_value' => $r['old_value'],
                'new_value' => $r['new_value'],
            ];
        }
        return array_values($grouped);
    }

    public function forUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE user_id = ?
             ORDER BY created_at DESC
             LIMIT 50"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findGroup(array $ids): array
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "SELECT r.*, u.name AS user_name, u.email AS user_email
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.id IN ($placeholders)"
        );
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }

    public function markGroup(array $ids, string $status, int $adminId, ?string $note = null): void
    {
        if (empty($ids)) return;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "UPDATE {$this->table}
             SET status = ?, reviewed_by = ?, reviewed_at = NOW(), admin_note = ?
             WHERE id IN ($placeholders)"
        );
        $stmt->execute(array_merge([$status, $adminId, $note], $ids));
    }

    public function pendingCount(): int
    {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM {$this->table} WHERE status = 'pending'"
        )->fetchColumn();
    }
}
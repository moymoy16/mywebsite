<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';
    private array $profileFields = [
        'name', 'email', 'student_id', 'section', 'gender', 'year_level', 'age'
    ];

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "INSERT INTO users
                (name, email, password, role, student_id, section, gender, year_level, age)
            VALUES (?, ?, ?, 'student', ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['name'],
            $data['email'],
            $hash,
            $data['student_id'] ?: null,
            $data['section']    ?: null,
            $data['gender']     ?: null,
            $data['year_level'] ?: null,
            !empty($data['age']) ? (int)$data['age'] : null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    // ═══ ADDED: used by admin when resolving reset requests ═══
    public function updatePassword(int $userId, string $newPlainPassword): void
    {
        $hash = password_hash($newPlainPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "UPDATE users
            SET password = ?, must_change_password = 1   -- ═══ ADDED ═══
            WHERE id = ?"
        );
        $stmt->execute([$hash, $userId]);
    }

    public function all(): array
    {
        return $this->db->query(
            "SELECT id, name, email, role, created_at
            FROM users
            ORDER BY created_at DESC"
        )->fetchAll();
    }

    // ═══ ADDED: force password change flow ═══
    public function setMustChangePassword(int $userId, bool $flag): void
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET must_change_password = ? WHERE id = ?"
        );
        $stmt->execute([$flag ? 1 : 0, $userId]);
    }

    public function updatePasswordAndClearFlag(int $userId, string $plainPassword): void
    {
        $hash = password_hash($plainPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "UPDATE users
            SET password = ?, must_change_password = 0
            WHERE id = ?"
        );
        $stmt->execute([$hash, $userId]);
    }
    // ═══ END ADDED ═══

    public function adminUpdateProfile(int $userId, array $data): void
    {
        $updates = [];
        $params  = [];

        foreach ($this->profileFields as $field) {
            if (array_key_exists($field, $data)) {
                $updates[] = "$field = ?";
                $params[]  = $data[$field];
            }
        }

        if (empty($updates)) return;

        $params[] = $userId;
        $stmt = $this->db->prepare(
            "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?"
        );
        $stmt->execute($params);
    }

    // ═══ ADDED: for admin user list with filters ═══
    public function adminFilter(string $search = '', string $role = ''): array
    {
        $sql    = "SELECT id, name, email, role, student_id, section, gender, year_level, age, created_at
                FROM users WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR student_id LIKE ? OR section LIKE ?)";
            $like = '%' . $search . '%';
            array_push($params, $like, $like, $like, $like);
        }

        if ($role === 'admin' || $role === 'student') {
            $sql .= " AND role = ?";
            $params[] = $role;
        }

        $sql .= " ORDER BY role ASC, name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findByStudentId(string $studentId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE student_id = ? LIMIT 1");
        $stmt->execute([$studentId]);
        return $stmt->fetch() ?: null;
    }
}
<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\ProfileChangeRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): void
    {
        Middleware::admin();

        $this->view('admin/profiles/index', [
            'title' => 'Student Profiles',
            'users' => (new User())->all(),
        ]);
    }

    public function edit(string $userId): void
    {
        Middleware::admin();

        $user = (new User())->find((int)$userId);
        if (!$user) { redirect('/admin/profiles'); }

        $this->view('admin/profiles/edit', [
            'title'  => 'Edit Profile',
            'target' => $user,
        ]);
    }

    public function update(string $userId): void
    {
        Middleware::admin();

        $userModel = new User();
        $target    = $userModel->find((int)$userId);
        if (!$target) { redirect('/admin/profiles'); }

        $name       = trim($_POST['name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $student_id = trim($_POST['student_id'] ?? '');
        $section    = trim($_POST['section'] ?? '');
        $gender     = trim($_POST['gender'] ?? '');
        $year_level = trim($_POST['year_level'] ?? '');
        $age        = (int)($_POST['age'] ?? 0);
        $errors     = [];

        if ($name === '')  $errors[] = 'Name is required.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email is required.';
        }
        if ($age > 0 && ($age < 10 || $age > 100)) {
            $errors[] = 'Age must be between 10 and 100.';
        }

        if ($errors) {
            $this->view('admin/profiles/edit', [
                'title'  => 'Edit Profile',
                'target' => $target,
                'errors' => $errors,
            ]);
            return;
        }

        $userModel->adminUpdateProfile((int)$userId, [
            'name'       => $name,
            'email'      => $email,
            'student_id' => $student_id ?: null,
            'section'    => $section ?: null,
            'gender'     => $gender ?: null,
            'year_level' => $year_level ?: null,
            'age'        => $age > 0 ? $age : null,
        ]);

        $_SESSION['flash'] = 'Profile updated successfully.';
        redirect('/admin/profiles');
    }

    public function requests(): void
    {
        Middleware::admin();

        $this->view('admin/profiles/requests', [
            'title'    => 'Profile Change Requests',
            'groups'   => (new ProfileChangeRequest())->pendingGrouped(),
        ]);
    }

    public function approve(string $groupId): void
    {
        Middleware::admin();

        $ids = array_filter(array_map('intval', explode('-', $groupId)));
        $rows = (new ProfileChangeRequest())->findGroup($ids);
        if (empty($rows)) { redirect('/admin/profiles/requests'); }

        // Group by user (should be one user only)
        $userId = (int)$rows[0]['user_id'];
        $updates = [];
        foreach ($rows as $r) {
            $updates[$r['field_name']] = $r['new_value'];
        }

        (new User())->adminUpdateProfile($userId, $updates);
        (new ProfileChangeRequest())->markGroup($ids, 'approved', (int)$_SESSION['user_id']);

        $_SESSION['flash'] = 'Profile changes approved and applied.';
        redirect('/admin/profiles/requests');
    }

    public function reject(string $groupId): void
    {
        Middleware::admin();

        $note = trim($_POST['admin_note'] ?? '');
        $ids  = array_filter(array_map('intval', explode('-', $groupId)));

        (new ProfileChangeRequest())->markGroup(
            $ids,
            'rejected',
            (int)$_SESSION['user_id'],
            $note ?: 'No reason provided.'
        );

        $_SESSION['flash'] = 'Change request rejected.';
        redirect('/admin/profiles/requests');
    }
}
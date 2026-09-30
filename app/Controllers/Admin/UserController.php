<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\PasswordReset;
use App\Models\ProfileChangeRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        Middleware::admin();

        $userModel  = new User();
        $resetModel = new PasswordReset();
        $profModel  = new ProfileChangeRequest();

        // Optional search + role filter
        $search = trim($_GET['search'] ?? '');
        $role   = trim($_GET['role']   ?? '');

        $users = $userModel->adminFilter($search, $role);

        // Tab: users | password | profile
        $tab = $_GET['tab'] ?? 'users';

        $this->view('admin/users/index', [
            'title'         => 'User Management',
            'tab'           => $tab,
            'users'         => $users,
            'search'        => $search,
            'role'          => $role,

            // Counts for badges
            'pendingResets'    => $resetModel->pendingCount(),
            'pendingProfiles'  => $profModel->pendingCount(),

            // Data for other tabs
            'passwordRequests' => $resetModel->allRequests(),
            'profileGroups'    => $profModel->pendingGrouped(),
        ]);
    }

    // ═══ PASSWORD RESET ═══
    public function resetPassword(string $requestId): void
    {
        Middleware::admin();

        $resetModel = new PasswordReset();
        $request    = $resetModel->find((int)$requestId);

        if (!$request || $request['status'] !== 'pending') {
            redirect('/admin/users?tab=password');
        }

        $this->view('admin/users/reset', [
            'title'   => 'Reset Password',
            'request' => $request,
        ]);
    }

    public function performReset(string $requestId): void
    {
        Middleware::admin();

        $resetModel = new PasswordReset();
        $request    = $resetModel->find((int)$requestId);

        if (!$request || $request['status'] !== 'pending') {
            redirect('/admin/users?tab=password');
        }

        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';
        $errors   = [];

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }

        if ($errors) {
            $this->view('admin/users/reset', [
                'title'   => 'Reset Password',
                'request' => $request,
                'errors'  => $errors,
            ]);
            return;
        }

        (new User())->updatePassword((int)$request['user_id'], $password);
        $resetModel->markResolved((int)$requestId, (int)$_SESSION['user_id']);

        $_SESSION['flash'] = 'Password reset for ' . $request['user_name'] . '.';
        redirect('/admin/users?tab=password');
    }

    public function cancelRequest(string $requestId): void
    {
        Middleware::admin();

        (new PasswordReset())->markResolved((int)$requestId, (int)$_SESSION['user_id']);
        redirect('/admin/users?tab=password');
    }

    // ═══ PROFILE — direct edit ═══
    public function editProfile(string $userId): void
    {
        Middleware::admin();

        $user = (new User())->find((int)$userId);
        if (!$user) { redirect('/admin/users'); }

        $this->view('admin/profiles/edit', [
            'title'  => 'Edit Profile',
            'target' => $user,
        ]);
    }

    public function updateProfile(string $userId): void
    {
        Middleware::admin();

        $userModel = new User();
        $target    = $userModel->find((int)$userId);
        if (!$target) { redirect('/admin/users'); }

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
        redirect('/admin/users');
    }

    // ═══ PROFILE REQUESTS ═══
    public function approveProfileRequest(string $groupId): void
    {
        Middleware::admin();

        $ids = array_filter(array_map('intval', explode('-', $groupId)));
        $rows = (new ProfileChangeRequest())->findGroup($ids);
        if (empty($rows)) { redirect('/admin/users?tab=profile'); }

        $userId  = (int)$rows[0]['user_id'];
        $updates = [];
        foreach ($rows as $r) {
            $updates[$r['field_name']] = $r['new_value'];
        }

        (new User())->adminUpdateProfile($userId, $updates);
        (new ProfileChangeRequest())->markGroup($ids, 'approved', (int)$_SESSION['user_id']);

        $_SESSION['flash'] = 'Profile changes approved and applied.';
        redirect('/admin/users?tab=profile');
    }

    public function rejectProfileRequest(string $groupId): void
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
        redirect('/admin/users?tab=profile');
    }

    public function resetDirect(string $userId): void
    {
        Middleware::admin();

        $user = (new User())->find((int)$userId);
        if (!$user || $user['role'] !== 'student') {
            redirect('/admin/users');
        }

        $this->view('admin/users/reset-direct', [
            'title'  => 'Reset Password',
            'target' => $user,
        ]);
    }

    public function performDirectReset(string $userId): void
    {
        Middleware::admin();

        $userModel = new User();
        $target    = $userModel->find((int)$userId);
        if (!$target || $target['role'] !== 'student') {
            redirect('/admin/users');
        }

        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';
        $errors   = [];

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }

        if ($errors) {
            $this->view('admin/users/reset-direct', [
                'title'  => 'Reset Password',
                'target' => $target,
                'errors' => $errors,
            ]);
            return;
        }

        $userModel->updatePassword((int)$userId, $password);

        $_SESSION['flash'] = 'Password reset for ' . $target['name'] . '.';
        redirect('/admin/users');
    }
}
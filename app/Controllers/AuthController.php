<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (!empty($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function showSignup(): void
    {
        if (!empty($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        $this->view('auth/signup', ['title' => 'Sign Up']);
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        if ($email === '' || $password === '') {
            $errors[] = 'Email and password are required.';
        } else {
            $user = (new User())->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = 'Invalid email or password.';
            }
        }

        if ($errors) {
            $this->view('auth/login', [
                'title'  => 'Login',
                'errors' => $errors,
                'old'    => ['email' => $email],
            ]);
            return;
        }

        $_SESSION['user_id']   = (int)$user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['must_change_password'] = (int)($user['must_change_password'] ?? 0);  // ═══ ADDED ═══
        session_regenerate_id(true);

        // ═══ ADDED: force password change on next login ═══
        if (!empty($user['must_change_password'])) {
            redirect('/change-password');
        }

        if ($user['role'] === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/dashboard');
        }
    }

    public function signup(): void
    {
        $name       = trim($_POST['name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $student_id = trim($_POST['student_id'] ?? '');
        $section    = trim($_POST['section'] ?? '');
        $gender     = trim($_POST['gender'] ?? '');
        $year_level = trim($_POST['year_level'] ?? '');
        $age        = (int)($_POST['age'] ?? 0);
        $password   = $_POST['password'] ?? '';
        $confirm    = $_POST['password_confirm'] ?? '';
        $errors     = [];

        // ═══ Basic validation ═══
        if ($name === '')  $errors[] = 'Full name is required.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email.';
        }
        if ($student_id === '') $errors[] = 'Student ID is required.';
        if ($section === '')    $errors[] = 'Section is required.';
        if ($gender === '' || !in_array($gender, ['Male','Female','Other'], true)) {
            $errors[] = 'Please select your gender.';
        }
        if ($year_level === '' || !in_array($year_level, ['1st Year','2nd Year','3rd Year','4th Year'], true)) {
            $errors[] = 'Please select your year level.';
        }
        if ($age < 10 || $age > 100) $errors[] = 'Please enter a valid age (10–100).';
        if (strlen($password) < 6)   $errors[] = 'Password must be at least 6 characters.';
        if ($password !== $confirm)  $errors[] = 'Passwords do not match.';

        // ═══ Uniqueness checks ═══
        $userModel = new User();
        if (!$errors && $userModel->findByEmail($email)) {
            $errors[] = 'That email is already registered.';
        }
        if (!$errors && $student_id !== '' && $userModel->findByStudentId($student_id)) {
            $errors[] = 'That student ID is already registered.';
        }

        if ($errors) {
            $this->view('auth/signup', [
                'title'  => 'Sign Up',
                'errors' => $errors,
                'old'    => [
                    'name'       => $name,
                    'email'      => $email,
                    'student_id' => $student_id,
                    'section'    => $section,
                    'gender'     => $gender,
                    'year_level' => $year_level,
                    'age'        => $age,
                ],
            ]);
            return;
        }

        // ═══ Create the user ═══
        $id = $userModel->create([
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'student_id' => $student_id,
            'section'    => $section,
            'gender'     => $gender,
            'year_level' => $year_level,
            'age'        => $age,
        ]);

        $_SESSION['user_id']   = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['role']      = 'student';
        $_SESSION['must_change_password'] = 0;
        session_regenerate_id(true);

        redirect('/dashboard');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        redirect('/login');
    }

    public function showForgot(): void
    {
        $this->view('auth/forgot', ['title' => 'Forgot Password']);
    }

    public function sendReset(): void
    {
        $email  = trim($_POST['email'] ?? '');
        $note   = trim($_POST['note'] ?? '');
        $errors = [];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ($errors) {
            $this->view('auth/forgot', [
                'title'  => 'Forgot Password',
                'errors' => $errors,
                'old'    => ['email' => $email],
            ]);
            return;
        }

        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        // Silent success if email doesn't exist — no account enumeration
        if ($user) {
            $resetModel = new PasswordReset();

            if (!$resetModel->hasPendingRequest((int)$user['id'])) {
                $resetModel->createRequest((int)$user['id'], $note ?: null);
            }
        }

        $this->view('auth/forgot', [
            'title' => 'Forgot Password',
            'sent'  => true,
            'email' => $email,
        ]);
    }

    // ═══ ADDED: force password change flow ═══
    public function showChangePassword(): void
    {
        if (empty($_SESSION['user_id'])) {
            redirect('/login');
        }

        // If flag isn't set, they shouldn't be here
        if (empty($_SESSION['must_change_password'])) {
            redirect(($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard');
        }

        $this->view('auth/change-password', ['title' => 'Change Password']);
    }

    public function changePassword(): void
    {
        if (empty($_SESSION['user_id'])) {
            redirect('/login');
        }

        if (empty($_SESSION['must_change_password'])) {
            redirect(($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard');
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

        // Prevent reusing the temporary password
        $userModel = new User();
        $current   = $userModel->find((int)$_SESSION['user_id']);
        if ($current && password_verify($password, $current['password'])) {
            $errors[] = 'Please choose a different password than the temporary one.';
        }

        if ($errors) {
            $this->view('auth/change-password', [
                'title'  => 'Change Password',
                'errors' => $errors,
            ]);
            return;
        }

        $userModel->updatePasswordAndClearFlag((int)$_SESSION['user_id'], $password);

        // Clear the session flag
        $_SESSION['must_change_password'] = 0;

        $_SESSION['flash'] = 'Your password has been updated successfully.';
        redirect(($_SESSION['role'] ?? '') === 'admin' ? '/admin/dashboard' : '/dashboard');
    }
    // ═══ END ADDED ═══

    public function showReset(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            redirect('/forgot-password');
        }

        $record = (new PasswordReset())->findValidByRawToken($token);

        if (!$record) {
            $this->view('auth/reset', [
                'title' => 'Reset Password',
                'invalid' => true,
            ]);
            return;
        }

        $this->view('auth/reset', [
            'title' => 'Reset Password',
            'token' => $token,
        ]);
    }

    public function resetPassword(): void
    {
        $token    = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';
        $errors   = [];

        $resetModel = new PasswordReset();
        $record     = $resetModel->findValidByRawToken($token);

        if (!$record) {
            $this->view('auth/reset', [
                'title'   => 'Reset Password',
                'invalid' => true,
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }

        if ($errors) {
            $this->view('auth/reset', [
                'title'  => 'Reset Password',
                'token'  => $token,
                'errors' => $errors,
            ]);
            return;
        }

        // Update password
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = \App\Core\Database::get()->prepare(
            "UPDATE users SET password = ? WHERE id = ?"
        );
        $stmt->execute([$hash, (int)$record['user_id']]);

        // Invalidate the token
        $resetModel->markUsed((int)$record['id']);

        // Flash a success message via session
        $_SESSION['flash'] = 'Your password has been reset. Please sign in.';
        redirect('/login');
    }
}
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

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
        $_SESSION['role']      = $user['role'];   // ← add this  
        $_SESSION['user_name'] = $user['name'];
        session_regenerate_id(true);   // prevents session fixation

       if ($user['role'] === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/dashboard');   // ═══ CHANGED: was /items ═══
        }
    }

    public function signup(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['password_confirm'] ?? '';
        $errors   = [];

        if ($name === '' || $email === '' || $password === '') {
            $errors[] = 'All fields are required.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }

        $userModel = new User();
        if (!$errors && $userModel->findByEmail($email)) {
            $errors[] = 'That email is already registered.';
        }

        if ($errors) {
            $this->view('auth/signup', [
                'title'  => 'Sign Up',
                'errors' => $errors,
                'old'    => ['name' => $name, 'email' => $email],
            ]);
            return;
        }

        $id = $userModel->create($name, $email, $password);

        $_SESSION['user_id']   = $id;
        $_SESSION['role'] = 'student';
        $_SESSION['user_name'] = $name;
        session_regenerate_id(true);

        if ($user['role'] === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/dashboard');   // ═══ CHANGED: was /items ═══
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        redirect('/login');
    }
}
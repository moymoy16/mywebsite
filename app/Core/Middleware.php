<?php
namespace App\Core;

class Middleware
{
    public static function admin(): void
    {
        if (empty($_SESSION['user_id'])) {
            redirect('/login');
        }
        if (($_SESSION['role'] ?? '') !== 'admin') {
            http_response_code(403);
            exit('Forbidden: admin only.');
        }
    }

    public static function student(): void
    {
        if (empty($_SESSION['user_id'])) {
            redirect('/login');
        }
        if (($_SESSION['role'] ?? '') !== 'student') {
            http_response_code(403);
            exit('Forbidden: students only.');
        }
    }
}
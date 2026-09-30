<?php
namespace App\Core;

class App
{
    public function run(): void
    {
        try {
            (new \App\Models\Borrowing())->markOverdue();
        } catch (\Throwable $e) {
            // Silently ignore if DB isn't ready yet — don't break the app
        }

        $this->enforcePasswordChange();
        
        $router = new Router();
        require BASE_PATH . '/routes/web.php';
        $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    private function enforcePasswordChange(): void
    {
        if (empty($_SESSION['user_id']))  return;
        if (empty($_SESSION['must_change_password'])) return;

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        $allowed = ['/change-password', '/logout'];
        if (in_array($uri, $allowed, true)) return;

        // Block everything else
        redirect('/change-password');
    }
}
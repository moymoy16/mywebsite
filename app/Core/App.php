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
        
        $router = new Router();
        require BASE_PATH . '/routes/web.php';
        $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
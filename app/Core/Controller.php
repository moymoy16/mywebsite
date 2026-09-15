<?php
namespace App\Core;

abstract class Controller
{
    
    protected function view(string $path, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/Views/' . $path . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: $path");
        }
        require $viewFile;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
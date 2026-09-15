<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use App\Core\App;

session_start();

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/Helpers/functions.php';
require BASE_PATH . '/config/config.php';

spl_autoload_register(function (string $class) {
    $prefix  = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));            // e.g. Core\App
    $file     = $baseDir . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

(new App())->run();
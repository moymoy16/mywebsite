<?php
namespace App\Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $uri, array $action): void  { $this->add('GET', $uri, $action); }
    public function post(string $uri, array $action): void { $this->add('POST', $uri, $action); }

    private function add(string $method, string $uri, array $action): void
    {
        // convert /user/{id} into regex
        $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $uri);
        $this->routes[$method]['#^' . $pattern . '$#'] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $pattern => $action) {
            if (preg_match($pattern, $uri, $matches)) {
                [$controller, $fn] = $action;
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                (new $controller())->$fn(...array_values($params));
                return;   // ← MUST be here
            }
        }

        http_response_code(404);
        require BASE_PATH . '/app/Views/errors/404.php';
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Routing;

use ReflectionClass;

final class Router
{
    private array $routes = [];

    public function register(string $controllerClass): void
    {
        $reflection = new ReflectionClass($controllerClass);

        foreach ($reflection->getMethods() as $method) {
            foreach ($method->getAttributes(Route::class) as $attribute) {
                $route = $attribute->newInstance();

                $this->routes[] = [
                    'path' => $route->path,
                    'methods' => $route->methods,
                    'controller' => $controllerClass,
                    'action' => $method->getName(),
                ];
            }
        }
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if (
                !in_array($method, $route['methods'], true)
                || $path !== $route['path']
            ) {
                continue;
            }

            $controller = new $route['controller']();
            $controller->{$route['action']}();

            return;
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}

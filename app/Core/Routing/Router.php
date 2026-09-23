<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Container\Container;
use App\Core\View\SmartyView;
use ReflectionClass;

final class Router
{
    private array $routes = [];

    public function __construct(
        private readonly Container $container
    ) {
    }

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
            if (!in_array($method, $route['methods'], true)) {
                continue;
            }

            $pattern = preg_replace(
                '#\{([^}]+)\}#',
                '([^/]+)',
                $route['path']
            );

            if (!preg_match('#^' . $pattern . '$#', $path, $matches)) {
                continue;
            }

            array_shift($matches);

            $matches = array_map(
                static fn (string $value): int|string =>
                ctype_digit($value) ? (int) $value : $value,
                $matches
            );

            $controller = $this->container->get($route['controller']);

            try {
                $controller->{$route['action']}(...$matches);
            } catch (\TypeError) {
                $this->notFound();
            }

            return;
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        $this->container->get(SmartyView::class)->notFound();
    }
}

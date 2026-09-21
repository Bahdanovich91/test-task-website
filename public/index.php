<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Core\Container\Container;
use App\Core\Routing\Router;

$container = new Container();
$router = new Router($container);

$router->register(HomeController::class);
$router->register(CategoryController::class);
$router->register(PostController::class);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

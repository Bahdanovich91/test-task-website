<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Core\Container\Container;
use App\Core\Routing\Router;

$container = new Container();
$router = new Router($container);

$router->register(HomeController::class);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

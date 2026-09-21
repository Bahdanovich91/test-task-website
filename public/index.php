<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Core\Routing\Router;

$router = new Router();

$router->register(HomeController::class);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

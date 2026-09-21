<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\View\SmartyView;

$view = new SmartyView();
$view->display('home.tpl');

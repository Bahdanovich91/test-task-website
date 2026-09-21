<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;

final class HomeController
{
    #[Route('/')]
    public function index(): void
    {
        $view = new SmartyView();

        $view->display('home.tpl');
    }

    #[Route('/test', ['POST'])]
    public function test(): void
    {
        var_dump($_POST);
    }
}

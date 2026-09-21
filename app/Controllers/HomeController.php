<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Models\Category;

final class HomeController
{
    public function __construct(
        private readonly SmartyView $view
    ) {
    }

    #[Route('/')]
    public function index(): void
    {
        $categories = Category::all();

        $this->view->assign('categories', $categories);
        $this->view->display('home.tpl');
    }
}

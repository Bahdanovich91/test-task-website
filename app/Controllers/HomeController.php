<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Services\HomeService;

readonly class HomeController
{
    public function __construct(
        private SmartyView  $view,
        private HomeService $homeService
    ) {
    }

    #[Route('/')]
    public function index(): void
    {
        $categories = $this->homeService->getCategoriesWithPosts();

        $this->view->assign('categories', $categories);
        $this->view->assign('title', 'Site');
        $this->view->display('home.tpl');
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Services\CategoryService;

readonly class CategoryController
{
    public function __construct(
        private SmartyView      $view,
        private CategoryService $categoryService
    ) {
    }

    #[Route('/category/{id}')]
    public function show(int $id): void
    {
        $sort = $_GET['sort'] ?? 'date';
        $direction = $_GET['direction'] ?? 'DESC';
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $data = $this->categoryService->getCategoryPageData(
            $id,
            $sort,
            $direction,
            $page
        );

        if ($data === null) {
            http_response_code(404);
            echo 'Category not found';
            return;
        }

        $this->view->assign('data', $data);
        $this->view->display('category.tpl');
    }
}
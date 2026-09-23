<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Dto\PostQueryDto;
use App\Enum\PostSort;
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
        $query = PostQueryDto::fromGlobals();
        $data = $this->categoryService->getCategoryPageData($id, $query);

        if (!$data) {
            $this->view->notFound();

            return;
        }

        $data['sortOptions'] = PostSort::toViewOptions($query->sort, $query->direction);

        $this->view->assign('data', $data);
        $this->view->display('category.tpl');
    }
}

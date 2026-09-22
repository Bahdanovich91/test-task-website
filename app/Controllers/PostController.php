<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Services\PostService;

readonly class PostController
{
    public function __construct(
        private SmartyView  $view,
        private PostService $postService
    ) {
    }

    #[Route('/posts')]
    public function index(): void
    {
        $sort = $_GET['sort'] ?? 'date';
        $direction = $_GET['direction'] ?? 'DESC';
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $data = $this->postService->getPostsPageData(
            $sort,
            $direction,
            $page
        );

        $this->view->assign('data', $data);
        $this->view->display('posts.tpl');
    }

    #[Route('/post/{id}')]
    public function show(int $id): void
    {
        $data = $this->postService->getPostPageData($id);
        if (!$data) {
            http_response_code(404);
            echo 'Post not found';

            return;
        }

        $this->view->assign('data', $data);
        $this->view->display('post.tpl');
    }
}

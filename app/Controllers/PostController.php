<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Routing\Route;
use App\Core\View\SmartyView;
use App\Dto\PostQueryDto;
use App\Enum\PostSort;
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
        $query = PostQueryDto::fromGlobals();
        $data = $this->postService->getPostsPageData($query);

        $data['sortOptions'] = PostSort::toViewOptions($query->sort, $query->direction);

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

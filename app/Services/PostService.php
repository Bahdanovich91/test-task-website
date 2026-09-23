<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\PostRepository;

readonly class PostService
{
    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    public function getPostPageData(int $id): ?array
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return null;
        }

        $this->postRepository->incrementViews($id);

        return [
            'post' => $post,
            'categories' => $this->postRepository->getCategoriesByPost($id),
            'similarPosts' => $this->postRepository->findSimilar($id),
        ];
    }

    public function getPostsPageData(
        string $sort,
        string $direction,
        int $page
    ): array {
        return $this->postRepository->getPaginated(
            $sort,
            $direction,
            $page
        );
    }
}

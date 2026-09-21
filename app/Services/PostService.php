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

        $post['views_count']++;

        return [
            'post' => $post,
            'similarPosts' => $this->postRepository->findSimilar($id),
        ];
    }
}

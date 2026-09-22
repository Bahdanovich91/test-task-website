<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

readonly class HomeService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
    ) {
    }

    public function getCategoriesWithPosts(): array
    {
        $result = [];

        foreach ($this->categoryRepository->getWithPosts() as $category) {
            $result[] = [
                'category' => $category,
                'posts' => $this->postRepository->getLatestByCategory(
                    $category->id,
                    3
                ),
            ];
        }

        return $result;
    }
}

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
        $categories = $this->categoryRepository->getWithPosts();
        $posts = $this->postRepository->getLatestForCategories();

        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                'category' => $category,
                'posts' => $posts[$category->id] ?? [],
            ];
        }

        return $result;
    }
}

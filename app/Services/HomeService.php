<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CategoryRepository;

readonly class HomeService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function getCategoriesWithPosts(): array
    {
        $result = [];
        foreach ($this->categoryRepository->getWithPosts() as $category) {
            $result[] = [
                'category' => $category,
                'posts' => array_slice(
                    $postsByCategory[$category->id] ?? [],
                    0,
                    3
                ),
            ];
        }

        return $result;
    }
}

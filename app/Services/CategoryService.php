<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\PostQueryDto;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

readonly class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private PostRepository     $postRepository
    ) {
    }

    public function getCategoryPageData(int $id, PostQueryDto $query): ?array
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return null;
        }

        return [
            'category' => $category,
            ...$this->postRepository->getPaginatedByCategory($id, $query),
        ];
    }
}

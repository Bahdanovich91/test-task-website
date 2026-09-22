<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database\Database;
use App\Models\Category;

class CategoryRepository
{
    public function getAll(): array
    {
        return Category::all();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    public function getWithPosts(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT DISTINCT categories.*
         FROM categories
         INNER JOIN post_category
             ON post_category.category_id = categories.id
         ORDER BY categories.name'
        );

        $rows = $stmt->fetchAll();

        return array_map(
            fn(array $row): Category => new Category($row),
            $rows
        );
    }
}

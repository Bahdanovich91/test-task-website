<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll(): array
    {
        return Category::all();
    }
}

<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database\Database;

class PostRepository
{
    public function getLatestByCategory(int $categoryId, int $limit): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT posts.*
         FROM posts
         INNER JOIN post_category AS pc
             ON pc.post_id = posts.id
         WHERE pc.category_id = ?
         ORDER BY posts.created_at DESC
         LIMIT ' . $limit
        );

        $stmt->execute([$categoryId]);

        return $stmt->fetchAll();
    }
}

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

    public function getPaginatedByCategory(
        int    $categoryId,
        string $sort = 'date',
        string $direction = 'DESC',
        int    $page = 1,
        int    $perPage = 5
    ): array
    {
        $orderBy = $sort === 'views'
            ? 'views_count'
            : 'created_at';

        $direction = strtoupper($direction) === 'ASC'
            ? 'ASC'
            : 'DESC';

        $total = $this->countByCategory($categoryId);
        $totalPages = (int)ceil($total / $perPage);

        $page = max(1, min($page, $totalPages ?: 1));
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT posts.*
         FROM posts
         INNER JOIN post_category
             ON post_category.post_id = posts.id
         WHERE post_category.category_id = ?
         ORDER BY {$orderBy} {$direction}
         LIMIT {$perPage} OFFSET {$offset}"
        );

        $stmt->execute([$categoryId]);

        return [
            'posts' => $stmt->fetchAll(),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'direction' => $direction,
        ];
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT COUNT(*)
         FROM post_category
         WHERE category_id = ?'
        );

        $stmt->execute([$categoryId]);

        return (int)$stmt->fetchColumn();
    }
}

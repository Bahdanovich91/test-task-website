<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database\Database;
use App\Models\Category;
use App\Models\Post;
use PDO;

class PostRepository
{
    private function db(): PDO
    {
        return Database::getConnection();
    }

    public function getLatestByCategory(int $categoryId, int $limit): array
    {
        $stmt = $this->db()->prepare(
            'SELECT posts.*
             FROM posts
             INNER JOIN post_category AS pc ON pc.post_id = posts.id
             WHERE pc.category_id = ?
             ORDER BY posts.created_at DESC
             LIMIT ?'
        );

        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $this->mapToModels($stmt->fetchAll());
    }

    public function getPaginatedByCategory(
        int    $categoryId,
        string $sort = 'date',
        string $direction = 'DESC',
        int    $page = 1,
        int    $perPage = 5
    ): array {
        $orderBy = $sort === 'views' ? 'views_count' : 'created_at';
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $total = $this->countByCategory($categoryId);
        $totalPages = (int) ceil($total / $perPage);

        $page = max(1, min($page, $totalPages ?: 1));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT posts.*
                FROM posts
                INNER JOIN post_category ON post_category.post_id = posts.id
                WHERE post_category.category_id = ?
                ORDER BY {$orderBy} {$direction}
                LIMIT ? OFFSET ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'posts' => $this->mapToModels($stmt->fetchAll()),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'direction' => $direction,
        ];
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db()->prepare(
            'SELECT COUNT(*) FROM post_category WHERE category_id = ?'
        );

        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?Post
    {
        $stmt = $this->db()->prepare(
            'SELECT * FROM posts WHERE id = ? LIMIT 1'
        );

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row ? new Post($row) : null;
    }

    public function findSimilar(int $postId): array
    {
        $stmt = $this->db()->prepare(
            'SELECT DISTINCT posts.*
             FROM posts
             INNER JOIN post_category ON post_category.post_id = posts.id
             WHERE post_category.category_id IN (
                 SELECT category_id FROM post_category WHERE post_id = ?
             )
             AND posts.id != ?
             ORDER BY posts.created_at DESC
             LIMIT 3'
        );

        $stmt->bindValue(1, $postId, PDO::PARAM_INT);
        $stmt->bindValue(2, $postId, PDO::PARAM_INT);
        $stmt->execute();

        return $this->mapToModels($stmt->fetchAll());
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db()->prepare(
            'UPDATE posts SET views_count = views_count + 1 WHERE id = ?'
        );

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function count(): int
    {
        return (int) $this->db()
            ->query('SELECT COUNT(*) FROM posts')
            ->fetchColumn();
    }

    public function getPaginated(
        string $sort = 'date',
        string $direction = 'DESC',
        int $page = 1,
        int $perPage = 10
    ): array {
        $orderBy = $sort === 'views' ? 'views_count' : 'created_at';
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $total = $this->count();
        $totalPages = (int) ceil($total / $perPage);

        $page = max(1, min($page, $totalPages ?: 1));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM posts
                ORDER BY {$orderBy} {$direction}
                LIMIT ? OFFSET ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'posts' => $this->mapToModels($stmt->fetchAll()),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'direction' => $direction,
        ];
    }

    private function mapToModels(array $rows): array
    {
        return array_map(
            static fn (array $row): Post => new Post($row),
            $rows
        );
    }

    public function getCategoriesByPost(int $postId): array
    {
        $stmt = $this->db()->prepare(
            'SELECT categories.*
         FROM categories
         INNER JOIN post_category AS pc ON pc.category_id = categories.id
         WHERE pc.post_id = ?
         ORDER BY categories.name'
        );

        $stmt->bindValue(1, $postId, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(
            static fn (array $row): Category => new Category($row),
            $stmt->fetchAll()
        );
    }
}

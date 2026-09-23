<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database\Database;
use App\Dto\PostQueryDto;
use App\Models\Category;
use App\Models\Post;
use PDO;

class PostRepository
{
    private function db(): PDO
    {
        return Database::getConnection();
    }

    public function getLatestForCategories(): array
    {
        $stmt = $this->db()->query(
            'SELECT *
             FROM (
                 SELECT
                     c.id AS category_id,
                     p.*,
                     ROW_NUMBER() OVER (
                         PARTITION BY c.id
                         ORDER BY p.created_at DESC, p.id DESC
                     ) AS rn
                 FROM categories c
                 INNER JOIN post_category pc ON pc.category_id = c.id
                 INNER JOIN posts p ON p.id = pc.post_id
             ) AS ranked
             WHERE rn <= 3'
        );

        $result = [];

        foreach ($stmt->fetchAll() as $row) {
            $result[$row['category_id']][] = new Post($row);
        }

        return $result;
    }

    public function getPaginatedByCategory(int $categoryId, PostQueryDto $query): array
    {
        $orderBy = $query->sort->column();
        $direction = $query->direction->value;

        $total = $this->countByCategory($categoryId);
        $totalPages = (int) ceil($total / $query->perPage);

        $page = max(1, min($query->page, $totalPages ?: 1));
        $offset = ($page - 1) * $query->perPage;

        $sql = "SELECT posts.*
                FROM posts
                INNER JOIN post_category ON post_category.post_id = posts.id
                WHERE post_category.category_id = ?
                ORDER BY {$orderBy} {$direction}
                LIMIT ? OFFSET ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $query->perPage, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'posts' => $this->mapToModels($stmt->fetchAll()),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $query->sort->value,
            'direction' => $query->direction->value,
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
            'SELECT posts.*
             FROM posts
             INNER JOIN post_category AS pc
                 ON pc.post_id = posts.id
             INNER JOIN post_category AS target_pc
                 ON target_pc.category_id = pc.category_id
                AND target_pc.post_id = :post_id
             WHERE posts.id != :post_id
             GROUP BY posts.id
             ORDER BY COUNT(pc.category_id) DESC, posts.created_at DESC
             LIMIT 3'
        );

        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
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

    public function getPaginated(PostQueryDto $query): array
    {
        $orderBy = $query->sort->column();
        $direction = $query->direction->value;

        $total = $this->count();
        $totalPages = (int) ceil($total / $query->perPage);

        $page = max(1, min($query->page, $totalPages ?: 1));
        $offset = ($page - 1) * $query->perPage;

        $sql = "SELECT * FROM posts
                ORDER BY {$orderBy} {$direction}
                LIMIT ? OFFSET ?";

        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(1, $query->perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'posts' => $this->mapToModels($stmt->fetchAll()),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $query->sort->value,
            'direction' => $query->direction->value,
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

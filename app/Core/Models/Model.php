<?php

declare(strict_types=1);

namespace App\Core\Models;

use App\Core\Database\Database;
use PDO;

abstract class Model
{
    protected static string $table;

    public function __construct(
        protected array $attributes = []
    ) {
    }

    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    public static function find(int $id): ?static
    {
        $stmt = static::db()->prepare(
            'SELECT * FROM ' . static::$table . ' WHERE id = ? LIMIT 1'
        );

        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? new static($row) : null;
    }

    public static function all(): array
    {
        $rows = static::db()
            ->query('SELECT * FROM ' . static::$table)
            ->fetchAll();

        return array_map(
            fn(array $row): static => new static($row),
            $rows
        );
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }
}

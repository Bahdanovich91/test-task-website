<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Models\Model;

final class Category extends Model
{
    protected static string $table = 'categories';

    public function getId(): int
    {
        return (int) $this->attr('id');
    }

    public function getName(): string
    {
        return (string) $this->attr('name');
    }

    public function getDescription(): string
    {
        return (string) $this->attr('description');
    }

    public function getCreatedAt(): string
    {
        return (string) $this->attr('created_at');
    }
}

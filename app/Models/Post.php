<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Models\Model;

final class Post extends Model
{
    protected static string $table = 'posts';

    public function getId(): int
    {
        return (int) $this->attr('id');
    }

    public function getTitle(): string
    {
        return (string) $this->attr('title');
    }

    public function getDescription(): string
    {
        return (string) $this->attr('description');
    }

    public function getText(): string
    {
        return (string) $this->attr('text');
    }

    public function getImage(): ?string
    {
        $image = $this->attr('image');

        return $image !== null && $image !== '' ? (string) $image : null;
    }

    public function getViewsCount(): int
    {
        return (int) $this->attr('views_count');
    }

    public function getCreatedAt(): string
    {
        return (string) $this->attr('created_at');
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum SortDirection: string
{
    case Asc = 'ASC';
    case Desc = 'DESC';

    public static function fromQuery(?string $value): self
    {
        $normalized = strtoupper($value ?? '');

        return self::tryFrom($normalized) ?? self::Desc;
    }

    public function toggle(): self
    {
        return match ($this) {
            self::Asc => self::Desc,
            self::Desc => self::Asc,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Asc => '↑',
            self::Desc => '↓',
        };
    }
}

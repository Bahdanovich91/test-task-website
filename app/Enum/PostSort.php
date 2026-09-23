<?php

declare(strict_types=1);

namespace App\Enum;

enum PostSort: string
{
    case Date = 'date';
    case Views = 'views';

    public static function fromQuery(?string $value): self
    {
        return self::tryFrom($value ?? '') ?? self::Date;
    }

    public function column(): string
    {
        return match ($this) {
            self::Date => 'created_at',
            self::Views => 'views_count',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Date => 'По дате',
            self::Views => 'По просмотрам',
        };
    }

    public static function toViewOptions(
        self $activeSort,
        SortDirection $activeDirection
    ): array {
        $options = [];

        foreach (self::cases() as $sort) {
            $isActive = $sort === $activeSort;

            $options[] = [
                'key' => $sort->value,
                'label' => $sort->label(),
                'isActive' => $isActive,
                'nextDirection' => $isActive
                    ? $activeDirection->toggle()->value
                    : SortDirection::Desc->value,
                'arrow' => $isActive ? $activeDirection->label() : '',
            ];
        }

        return $options;
    }
}

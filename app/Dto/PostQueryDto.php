<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\PostSort;
use App\Enum\SortDirection;

final readonly class PostQueryDto
{
    public function __construct(
        public PostSort $sort,
        public SortDirection $direction,
        public int $page,
        public int $perPage = 10,
    ) {
    }

    public static function fromGlobals(int $perPage = 10): self
    {
        return self::fromArray($_GET, $perPage);
    }

    public static function fromArray(array $input, int $perPage = 10): self
    {
        return new self(
            sort: PostSort::fromQuery($input['sort'] ?? null),
            direction: SortDirection::fromQuery($input['direction'] ?? null),
            page: max(1, (int) ($input['page'] ?? 1)),
            perPage: $perPage,
        );
    }
}

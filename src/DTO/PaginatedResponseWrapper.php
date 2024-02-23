<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

readonly class PaginatedResponseWrapper
{
    public function __construct(
        public array $data,
        public int $page,
        public int $perPage,
        public int $totalCount,
        public ?ResponseError $error = null,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PaginatedListResponse extends ListResponse
{
    protected function getProperties(string $class, array $errors): array
    {
        $paginationProperties = [
            new OA\Property(
                property: 'page',
                type: 'int',
                example: 1,
                nullable: true
            ),
            new OA\Property(
                property: 'perPage',
                type: 'int',
                example: 100,
                nullable: true
            ),
            new OA\Property(
                property: 'totalCount',
                type: 'int',
                example: 1,
                nullable: true
            ),
        ];

        return array_merge(parent::getProperties($class, $errors), $paginationProperties);
    }
}

<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Response extends AbstractResponse
{
    protected function getDataProperty(string $class): OA\Property
    {
        return new OA\Property(
            property: 'data',
            ref: new Model(type: $class),
            nullable: true,
        );
    }
}

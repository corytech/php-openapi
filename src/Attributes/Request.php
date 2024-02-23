<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER)]
class Request extends OA\RequestBody
{
    public function __construct(string $class)
    {
        parent::__construct(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    ref: new Model(type: $class)
                )
            )
        );
    }
}

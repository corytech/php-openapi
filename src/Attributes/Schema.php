<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class Schema extends OA\Schema
{
}

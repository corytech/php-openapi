<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Tag extends OA\Tag
{
}

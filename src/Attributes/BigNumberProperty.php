<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER | \Attribute::TARGET_CLASS_CONSTANT | \Attribute::IS_REPEATABLE)]
class BigNumberProperty extends Property
{
    public function __construct(...$args)
    {
        $args['format'] = 'number';
        $args['example'] = '10.23';
        parent::__construct(...$args);
    }
}

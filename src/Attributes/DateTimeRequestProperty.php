<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_PARAMETER | \Attribute::TARGET_CLASS_CONSTANT | \Attribute::IS_REPEATABLE)]
class DateTimeRequestProperty extends Property
{
    public function __construct(...$args)
    {
        $args['format'] = \sprintf('ISO-8601/RFC3339 date-time "%s"', \DateTimeInterface::ATOM);
        $args['example'] = (new \DateTimeImmutable('1985-10-26 01:21:00', timezone: new \DateTimeZone('UTC')))
            ->format(\DateTimeInterface::ATOM);
        parent::__construct(...$args);
    }
}

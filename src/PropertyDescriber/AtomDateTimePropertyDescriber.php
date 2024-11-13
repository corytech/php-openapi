<?php

declare(strict_types=1);

namespace Corytech\OpenApi\PropertyDescriber;

use Nelmio\ApiDocBundle\PropertyDescriber\DateTimePropertyDescriber;
use OpenApi\Annotations as OA;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('nelmio_api_doc.object_model.property_describer')]
class AtomDateTimePropertyDescriber extends DateTimePropertyDescriber
{
    public function describe(array $types, OA\Schema $property, ?array $groups = null, ?OA\Schema $schema = null, array $context = []): void
    {
        parent::describe($types, $property, $groups, $schema, $context);
        $property->format = \sprintf('UTC ISO-8601/RFC3339 date-time "%s"', \DateTimeInterface::ATOM);
        $property->example = (new \DateTimeImmutable(timezone: new \DateTimeZone('UTC')))
            ->format(\DateTimeInterface::ATOM);
    }
}

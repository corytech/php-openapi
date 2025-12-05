<?php

declare(strict_types=1);

namespace Corytech\OpenApi\PropertyDescriber;

use Nelmio\ApiDocBundle\PropertyDescriber\PropertyDescriberInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('nelmio_api_doc.object_model.property_describer')]
class AtomDateTimePropertyDescriber implements PropertyDescriberInterface
{
    public function describe(array $types, OA\Schema $property, ?array $groups = null, ?OA\Schema $schema = null, array $context = []): void
    {
        $property->type = 'string';
        $property->format = \sprintf('UTC ISO-8601/RFC3339 date-time "%s"', \DateTimeInterface::ATOM);
        $property->example = (new \DateTimeImmutable(timezone: new \DateTimeZone('UTC')))
            ->format(\DateTimeInterface::ATOM);
    }

    public function supports(array $types, array $context = []): bool
    {
        return \count($types) === 1 && is_a($types[0]->getClassName(), \DateTimeInterface::class, true);
    }
}

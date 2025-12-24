<?php

declare(strict_types=1);

namespace Corytech\OpenApi\PropertyDescriber;

use Nelmio\ApiDocBundle\TypeDescriber\TypeDescriberInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\TypeInfo\Type;

#[AutoconfigureTag('nelmio_api_doc.type_describer', ['priority' => -1001])]
class AtomDateTimePropertyDescriber implements TypeDescriberInterface
{
    public function describe(Type $type, OA\Schema $schema, array $context = []): void
    {
        $schema->type = 'string';
        $schema->format = \sprintf('UTC ISO-8601/RFC3339 date-time "%s"', \DateTimeInterface::ATOM);
        $schema->example = (new \DateTimeImmutable(timezone: new \DateTimeZone('UTC')))
            ->format(\DateTimeInterface::ATOM);
    }

    public function supports(Type $type, array $context = []): bool
    {
        return $type instanceof Type\ObjectType && is_a($type->getClassName(), \DateTimeInterface::class, true);
    }
}

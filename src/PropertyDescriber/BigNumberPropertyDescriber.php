<?php

declare(strict_types=1);

namespace Corytech\OpenApi\PropertyDescriber;

use Corytech\BigNumber\BigNumber;
use Nelmio\ApiDocBundle\PropertyDescriber\PropertyDescriberInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('nelmio_api_doc.object_model.property_describer')]
class BigNumberPropertyDescriber implements PropertyDescriberInterface
{
    public function describe(array $types, OA\Schema $property, ?array $groups = null, ?OA\Schema $schema = null, array $context = []): void
    {
        $property->type = 'string';
        $property->format = 'Number';
        $property->example = '10.23';
    }

    public function supports(array $types): bool
    {
        return \count($types) === 1 && $types[0]->getClassName() === BigNumber::class;
    }
}

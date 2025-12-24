<?php

declare(strict_types=1);

namespace Corytech\OpenApi\PropertyDescriber;

use Corytech\BigNumber\BigNumber;
use Nelmio\ApiDocBundle\TypeDescriber\TypeDescriberInterface;
use OpenApi\Annotations as OA;
use OpenApi\Generator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\TypeInfo\Type;

#[AutoconfigureTag('nelmio_api_doc.type_describer', ['priority' => -1001])]
class BigNumberPropertyDescriber implements TypeDescriberInterface
{
    public function describe(Type $type, OA\Schema $schema, array $context = []): void
    {
        $schema->type = 'string';
        $schema->format = 'Number';
        $schema->example = '10.23';
        $schema->ref = Generator::UNDEFINED;
    }

    public function supports(Type $type, array $context = []): bool
    {
        return $type instanceof Type\ObjectType && $type->getClassName() === BigNumber::class;
    }
}

<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Attributes;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;
use Corytech\OpenApi\DTO\ValidationErrorItem;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

abstract class AbstractResponse extends OA\Response
{
    /**
     * @param ApiErrorCodeInterface[] $errors
     */
    public function __construct(string $class, array $errors = [])
    {
        $errors = array_map(static fn (ApiErrorCodeInterface $code) => $code->getCode(), $errors);
        $errors = array_unique($errors);
        parent::__construct(
            response: 200,
            description: 'Response',
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: $this->getProperties($class, $errors),
                    type: 'object'
                )
            ),
        );
    }

    protected function getProperties(string $class, array $errors): array
    {
        return [
            new OA\Property(
                property: 'error',
                description: '`null` when no error',
                properties: [
                    new OA\Property(
                        property: 'code',
                        description: 'see [Error codes](#section/Error-codes) section for more details',
                        type: 'string',
                        enum: $errors,
                        nullable: false
                    ),
                    new OA\Property(
                        property: 'validationErrors',
                        description: sprintf('Validation errors when error.code is `%s`', CommonApiErrorCode::Validation->getCode()),
                        type: 'array',
                        items: new OA\Items(
                            ref: new Model(type: ValidationErrorItem::class)
                        ),
                        nullable: true
                    ),
                ],
                type: 'object',
                nullable: true
            ),
            $this->getDataProperty($class),
        ];
    }

    abstract protected function getDataProperty(string $class): OA\Property;
}

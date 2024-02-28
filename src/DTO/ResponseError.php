<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

readonly class ResponseError
{
    public function __construct(
        public ApiErrorCodeInterface $code,
        /**
         * @var ValidationErrorItem[]|null $validationErrors
         */
        public ?array $validationErrors = null,
    ) {
    }

    public function getCode(): string
    {
        return $this->code->getCode();
    }
}

<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Exception;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;

class MissingConstructorArgumentsApiException extends ApiException
{
    public function __construct(
        private readonly array $missingArguments,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }

    public function getErrorCode(): ApiErrorCodeInterface
    {
        return CommonApiErrorCode::Validation;
    }

    public function getMissingArguments(): array
    {
        return $this->missingArguments;
    }
}

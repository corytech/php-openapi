<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Exception;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationApiException extends ApiException
{
    public function __construct(
        private readonly ConstraintViolationListInterface $errors,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }

    public function getErrorCode(): ApiErrorCodeInterface
    {
        return CommonApiErrorCode::Validation;
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}

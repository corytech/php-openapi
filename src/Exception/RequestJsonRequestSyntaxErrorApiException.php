<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Exception;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;

class RequestJsonRequestSyntaxErrorApiException extends ApiException
{
    public function __construct(
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }

    public function getErrorCode(): ApiErrorCodeInterface
    {
        return CommonApiErrorCode::InvalidDataFormat;
    }
}

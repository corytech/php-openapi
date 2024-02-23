<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

enum CommonApiErrorCode: string implements ApiErrorCodeInterface
{
    case Unknown = 'UNKNOWN';
    case Validation = 'VALIDATION';
    case InvalidDataFormat = 'INVALID_DATA';
    case MethodNotFound = 'METHOD_NOT_FOUND';
    case InvalidHttpMethod = 'INVALID_HTTP_METHOD';
    case AccessDenied = 'ACCESS_DENIED';
    case AuthenticationFailed = 'AUTHENTICATION_FAILED';

    public function getCode(): string
    {
        return $this->value;
    }
}

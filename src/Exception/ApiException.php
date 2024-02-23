<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Exception;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;

class ApiException extends \Exception
{
    public function getErrorCode(): ApiErrorCodeInterface
    {
        return CommonApiErrorCode::Unknown;
    }
}

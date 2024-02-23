<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

interface ApiErrorCodeInterface extends \BackedEnum
{
    public function getCode(): string;
}

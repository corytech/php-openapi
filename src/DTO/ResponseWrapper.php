<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

readonly class ResponseWrapper
{
    public function __construct(
        public object|array|null $data,
        public ?ResponseError $error = null,
    ) {
    }
}

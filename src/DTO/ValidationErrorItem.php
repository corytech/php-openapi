<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DTO;

readonly class ValidationErrorItem
{
    public function __construct(
        public string $field,
        public string $message,
    ) {
    }
}

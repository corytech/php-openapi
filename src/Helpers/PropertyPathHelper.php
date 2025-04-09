<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Helpers;

final class PropertyPathHelper
{
    public static function formatPropertyPath(string $propertyPath): string
    {
        return str_replace('][', '.', trim($propertyPath, '[]'));
    }
}

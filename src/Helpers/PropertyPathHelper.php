<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Helpers;

final class PropertyPathHelper
{
    public static function formatPropertyPath(string $propertyPath): string
    {
        $path = preg_replace('/\[([^]]+)]/', '.$1', $propertyPath);

        return trim($path, '.');
    }
}

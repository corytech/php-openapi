<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Helpers;

class ApiDateTimeHelper
{
    public static function getFromApiRequestData(?string $data, ?\DateTimeImmutable $default = null): ?\DateTimeImmutable
    {
        if ($data === null) {
            return $default;
        }

        return \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $data)->setTimezone(new \DateTimeZone('UTC'));
    }
}

<?php

declare(strict_types=1);

use Corytech\OpenApi\Helpers\PropertyPathHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PropertyPathHelperTest extends TestCase
{
    public static function getTestCases(): iterable
    {
        return [
            [
                'foo[bar][baz]',
                'foo.bar.baz',
            ],
            [
                'foo[0]',
                'foo.0',
            ],
            [
                'foo[0][name]',
                'foo.0.name',
            ],
            [
                'foo[0].name',
                'foo.0.name',
            ],
            [
                'foo.bar[0].name',
                'foo.bar.0.name',
            ],
            [
                'foo[0].bar[2]',
                'foo.0.bar.2',
            ],
            [
                'foo[0].bar[2].name',
                'foo.0.bar.2.name',
            ],
            [
                'foo[0][bar][2][name]',
                'foo.0.bar.2.name',
            ],
        ];
    }

    #[DataProvider('getTestCases')]
    public function testFormatPropertyPath(string $propertyPath, string $expected): void
    {
        self::assertEquals($expected, PropertyPathHelper::formatPropertyPath($propertyPath));
    }
}
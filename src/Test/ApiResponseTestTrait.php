<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Test;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTestTrait
{
    public static function assertApiResponseIsSuccessful(Response $response): void
    {
        self::assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        self::assertJson($content);
        $content = json_decode($content, true, 512, \JSON_THROW_ON_ERROR);
        self::assertCount(2, $content);
        self::assertNull($content['error']);
        self::assertNotNull($content['data']);
    }

    public static function assertApiResponseIsError(Response $response, ApiErrorCodeInterface $errorCode): void
    {
        self::assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        self::assertJson($content);
        $content = json_decode($content, true, 512, \JSON_THROW_ON_ERROR);
        self::assertCount(2, $content);
        self::assertNull($content['data']);
        self::assertCount(2, $content['error']);
        self::assertNull($content['error']['validationErrors']);
        self::assertNotEquals('UNKNOWN', $content['error']['code']);
        self::assertEquals($errorCode->getCode(), $content['error']['code']);
    }

    /**
     * @param array<string,string[]> $expectedNotValidFields
     */
    public static function assertApiResponseIsValidationError(Response $response, array $expectedNotValidFields): void
    {
        self::assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        self::assertJson($content);
        $content = json_decode($content, true, 512, \JSON_THROW_ON_ERROR);
        self::assertCount(2, $content);
        self::assertNull($content['data']);
        self::assertCount(2, $content['error']);
        self::assertNotNull($content['error']['validationErrors'], 'validationErrors missed');
        self::assertEquals(CommonApiErrorCode::Validation->getCode(), $content['error']['code']);
        $grouped = [];
        foreach ($content['error']['validationErrors'] as $validationErrorItem) {
            self::assertCount(2, $validationErrorItem);
            self::assertNotNull($validationErrorItem['field']);
            self::assertNotNull($validationErrorItem['message']);
            if (!\array_key_exists($validationErrorItem['field'], $grouped)) {
                $grouped[$validationErrorItem['field']] = [];
            }
            $grouped[$validationErrorItem['field']][] = $validationErrorItem['message'];
        }

        $assertMessage = \sprintf(
            'Expected validation set `%s`, `%s` given',
            json_encode($expectedNotValidFields, \JSON_THROW_ON_ERROR),
            json_encode($grouped, \JSON_THROW_ON_ERROR),
        );

        foreach ($expectedNotValidFields as $field => $messages) {
            self::assertArrayHasKey($field, $grouped, $assertMessage);
            self::assertCount(\count($messages), $grouped[$field], $assertMessage);
            self::assertEqualsCanonicalizing($messages, $grouped[$field], $assertMessage);
        }
        self::assertEqualsCanonicalizing(array_keys($expectedNotValidFields), array_keys($grouped), $assertMessage);
    }
}

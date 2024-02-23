<?php

declare(strict_types=1);

namespace Corytech\OpenApi\Exception;

use Corytech\OpenApi\DTO\ApiErrorCodeInterface;
use Corytech\OpenApi\DTO\CommonApiErrorCode;

class NotNormalizableRequestApiException extends ApiException
{
    public function __construct(
        private readonly string $path,
        /**
         * @var string[]
         */
        private readonly array $expectedTypes,
        private readonly string $currentType,
        private readonly bool $useMessageForUser,
        string $message,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, previous: $previous);
    }

    public function getErrorCode(): ApiErrorCodeInterface
    {
        return CommonApiErrorCode::InvalidDataFormat;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string[]
     */
    public function getExpectedTypes(): array
    {
        return $this->expectedTypes;
    }

    public function getCurrentType(): string
    {
        return $this->currentType;
    }

    public function isUseMessageForUser(): bool
    {
        return $this->useMessageForUser;
    }
}

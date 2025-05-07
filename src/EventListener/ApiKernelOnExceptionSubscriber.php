<?php

declare(strict_types=1);

namespace Corytech\OpenApi\EventListener;

use Corytech\OpenApi\DTO\CommonApiErrorCode;
use Corytech\OpenApi\DTO\ResponseError;
use Corytech\OpenApi\DTO\ResponseWrapper;
use Corytech\OpenApi\DTO\ValidationErrorItem;
use Corytech\OpenApi\Exception\ApiException;
use Corytech\OpenApi\Exception\MissingConstructorArgumentsApiException;
use Corytech\OpenApi\Exception\NotNormalizableRequestApiException;
use Corytech\OpenApi\Exception\ValidationApiException;
use Corytech\OpenApi\Helpers\PropertyPathHelper;
use Corytech\Tracing\GlobalExceptionCatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiKernelOnExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly array $requestPathPrefixes,
        private readonly ?GlobalExceptionCatcher $exceptionCatcher,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        foreach ($this->requestPathPrefixes as $prefix) {
            if (str_starts_with($event->getRequest()->getPathInfo(), $prefix)) {
                $response = $this->getApiErrorResponse($event->getThrowable());

                $event->allowCustomResponseCode();
                $event->setResponse($response);
                break;
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    private function getApiErrorResponse(\Throwable $throwable): Response
    {
        $validationErrors = null;

        $errorCode = match (true) {
            $throwable instanceof NotFoundHttpException => CommonApiErrorCode::MethodNotFound,
            $throwable instanceof MethodNotAllowedHttpException => CommonApiErrorCode::InvalidHttpMethod,
            $throwable instanceof AccessDeniedHttpException => CommonApiErrorCode::AccessDenied,
            $throwable instanceof ApiException => $throwable->getErrorCode(),
            default => CommonApiErrorCode::Unknown,
        };

        if ($throwable instanceof MissingConstructorArgumentsApiException) {
            $validationErrors = array_map(
                static fn (string $field) => new ValidationErrorItem($field, 'Field is missing'),
                $throwable->getMissingArguments(),
            );
        } elseif ($throwable instanceof ValidationApiException) {
            $validationErrors = [];
            foreach ($throwable->getErrors() as $error) {
                $validationErrors[] = new ValidationErrorItem(
                    PropertyPathHelper::formatPropertyPath($error->getPropertyPath()),
                    (string) $error->getMessage(),
                );
            }
            $errorCode = CommonApiErrorCode::Validation;
        } elseif ($throwable instanceof NotNormalizableRequestApiException) {
            $message = $throwable->isUseMessageForUser()
                ? $throwable->getMessage()
                : \sprintf(
                    'Cannot unmarshal value. `%s` expected, `%s` given',
                    implode(', ', $throwable->getExpectedTypes()),
                    $throwable->getCurrentType(),
                );
            $validationErrors = [new ValidationErrorItem(PropertyPathHelper::formatPropertyPath($throwable->getPath()), $message)];
            $errorCode = CommonApiErrorCode::Validation;
        }

        if ($errorCode === CommonApiErrorCode::Unknown) {
            $this->exceptionCatcher?->captureException($throwable);
        }

        return JsonResponse::fromJsonString($this->serializer->serialize(
            new ResponseWrapper(null, new ResponseError($errorCode, $validationErrors)),
            JsonEncoder::FORMAT
        ));
    }
}

<?php

declare(strict_types=1);

namespace Corytech\OpenApi\ArgumentResolver;

use Corytech\OpenApi\DTO\ApiRequestDTOInterface;
use Corytech\OpenApi\Exception\MissingConstructorArgumentsApiException;
use Corytech\OpenApi\Exception\NotNormalizableRequestApiException;
use Corytech\OpenApi\Exception\RequestJsonRequestSyntaxErrorApiException;
use Corytech\OpenApi\Exception\ValidationApiException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiRequestDTOArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * @throws ValidationApiException
     * @throws NotNormalizableRequestApiException
     * @throws RequestJsonRequestSyntaxErrorApiException
     * @throws MissingConstructorArgumentsApiException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if ($argumentType === null || !is_subclass_of($argumentType, ApiRequestDTOInterface::class)) {
            return [];
        }
        try {
            /** @var ApiRequestDTOInterface $object */
            $object = $this->serializer->deserialize($request->getContent(), $argumentType, JsonEncoder::FORMAT);
        } catch (NotNormalizableValueException $e) {
            throw new NotNormalizableRequestApiException(
                path: $e->getPath() ?? '',
                expectedTypes: $e->getExpectedTypes() ?? [],
                currentType: $e->getCurrentType() ?? 'unknown',
                useMessageForUser: $e->canUseMessageForUser() ?? false,
                message: $e->getMessage(),
                previous: $e,
            );
        } catch (MissingConstructorArgumentsException $e) {
            throw new MissingConstructorArgumentsApiException($e->getMissingConstructorArguments(), $e);
        } catch (NotEncodableValueException $e) {
            throw new RequestJsonRequestSyntaxErrorApiException(previous: $e);
        }

        $errors = $this->validator->validate($object);

        if (\count($errors) > 0) {
            throw new ValidationApiException($errors);
        }

        yield $object;
    }
}

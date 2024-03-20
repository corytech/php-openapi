<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Corytech\OpenApi\ArgumentResolver\ApiRequestDTOArgumentResolver;
use Corytech\OpenApi\EventListener\ApiKernelOnExceptionSubscriber;
use Corytech\OpenApi\PropertyDescriber\AtomDateTimePropertyDescriber;
use Corytech\OpenApi\PropertyDescriber\BigNumberPropertyDescriber;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->defaults()
            ->autoconfigure()
            ->autowire()
        ->set(ApiKernelOnExceptionSubscriber::class, ApiKernelOnExceptionSubscriber::class)
        ->set(ApiRequestDTOArgumentResolver::class, ApiRequestDTOArgumentResolver::class)
        ->set(AtomDateTimePropertyDescriber::class, AtomDateTimePropertyDescriber::class)
        ->set(BigNumberPropertyDescriber::class, BigNumberPropertyDescriber::class)
    ;
};

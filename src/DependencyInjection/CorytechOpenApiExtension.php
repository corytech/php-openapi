<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DependencyInjection;

use Corytech\OpenApi\EventListener\ApiKernelOnExceptionSubscriber;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorytechOpenApiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $container
            ->getDefinition(ApiKernelOnExceptionSubscriber::class)
            ->setArgument('$requestPathPrefixes', $config['handle_exceptions_on_path_prefixes']);

    }
}
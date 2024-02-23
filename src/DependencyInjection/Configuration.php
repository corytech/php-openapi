<?php

declare(strict_types=1);

namespace Corytech\OpenApi\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('corytech_openapi');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('handle_exceptions_on_path_prefixes')
                    ->scalarPrototype()->end()
                ->beforeNormalization()->castToArray()->end()
        ;

        return $treeBuilder;
    }
}
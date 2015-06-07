<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app');

        $rootNode
            ->children()
                ->arrayNode('dashboard')
                    ->children()
                        ->arrayNode('items')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('title')
                                        ->defaultValue(null)
                                    ->end()
                                    ->scalarNode('route')->end()
                                    ->scalarNode('icon')
                                        ->defaultValue(null)
                                    ->end()
                                    ->booleanNode('active')
                                        ->defaultValue(true)
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

}

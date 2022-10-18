<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('run_console');

        $treeBuilder
            ->getRootNode()
            ->children()
            ->arrayNode('commands')
            ->scalarPrototype()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}

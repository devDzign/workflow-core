<?php

namespace InterInvest\Workflow\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('workflow_core');

        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}

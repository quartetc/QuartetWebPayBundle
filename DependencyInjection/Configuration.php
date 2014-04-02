<?php

namespace Quartet\Bundle\WebPayBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('quartet_webpay');

        $this->addGlobalConfig($root);

        return $builder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addGlobalConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('api_secret')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('api_public')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('api_base')
                    ->defaultNull()
                ->end()
                ->scalarNode('accept_language')
                ->end()
            ->end()
        ;
    }
}

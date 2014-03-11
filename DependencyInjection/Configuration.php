<?php

namespace Quartet\WebPayBundle\DependencyInjection;


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
        $this->addCustomerConfig($root);
        $this->addCheckoutConfig($root);
        $this->addTemplatingConfig($root);

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
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addCustomerConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('customer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('manager')->defaultValue('quartet_webpay.customer_manager.fos_user')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addCheckoutConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('checkout')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('payment_class')
                            ->defaultValue('Quartet\WebPayBundle\Model\Payment')
                        ->end()
                        ->arrayNode('payment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->enumNode('tokenize')
                                    ->values(array(true, false))
                                    ->defaultValue(true)
                                ->end()
                                ->enumNode('persistence')
                                    ->values(array('always', 'never', 'optional'))
                                    ->defaultValue('optional')
                                ->end()
                                ->arrayNode('form')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('type')->defaultValue('quartet_webpay_payment')->end()
                                        ->scalarNode('name')->defaultValue('quartet_webpay_payment')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }


    /**
     * @param ArrayNodeDefinition $node
     */
    private function addTemplatingConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('templating')
                            ->defaultValue('QuartetWebPayBundle:Form:fields.html.twig')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}

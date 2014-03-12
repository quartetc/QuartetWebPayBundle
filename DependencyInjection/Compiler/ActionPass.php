<?php

namespace Quartet\WebPayBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ActionPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('quartet_webpay.action.factory');

        $services = $container->findTaggedServiceIds('quartet_webpay.webpay_action');

        foreach ($services as $id => $tags) {
            $definition->addMethodCall('setAction', array(
                $tags[0]['alias'], new Reference($id)
            ));
        }
    }
}

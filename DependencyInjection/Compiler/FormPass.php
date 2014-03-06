<?php

namespace Quartet\Bundle\WebPayBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

        array_push($resources, $container->getParameter('quartet_webpay.form.templating'));

        $container->setParameter('twig.form.resources', $resources);
    }
}

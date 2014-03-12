<?php

namespace Quartet\WebPayBundle;

use Quartet\WebPayBundle\DependencyInjection\Compiler\ActionPass;
use Quartet\WebPayBundle\DependencyInjection\Compiler\FormPass;
use Quartet\WebPayBundle\DependencyInjection\QuartetWebPayExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class QuartetWebPayBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new QuartetWebPayExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormPass());
        $container->addCompilerPass(new ActionPass());
    }
}

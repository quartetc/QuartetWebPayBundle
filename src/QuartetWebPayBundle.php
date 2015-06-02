<?php

namespace Quartet\Bundle\WebPayBundle;

use Quartet\Bundle\WebPayBundle\DependencyInjection\QuartetWebPayExtension;
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
}

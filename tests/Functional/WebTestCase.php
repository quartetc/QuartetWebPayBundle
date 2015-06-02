<?php


namespace Quartet\Bundle\WebPayBundle\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass()
    {
        return 'Quartet\Bundle\WebPayBundle\Functional\TestKernel';
    }
}

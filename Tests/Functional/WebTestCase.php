<?php


namespace Quartet\Bundle\WebPayBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass()
    {
        return 'Quartet\Bundle\WebPayBundle\Tests\Functional\TestKernel';
    }
}

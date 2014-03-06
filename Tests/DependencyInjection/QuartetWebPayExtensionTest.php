<?php


namespace Quartet\Bundle\WebPayBundle\Tests\DependencyInjection;


use Quartet\Bundle\WebPayBundle\DependencyInjection\QuartetWebPayExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class QuartetWebPayExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new ContainerBuilder();
    }

    protected function tearDown()
    {
        $this->configuration = null;
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testThrowExceptionUnlessApiSecretSet()
    {
        $loader = new QuartetWebPayExtension();
        $config = $this->getEmptyConfig();
        unset($config['api_secret']);
        $loader->load([$config], $this->configuration);
    }

    public function testDefaultConfiguration()
    {
        $loader = new QuartetWebPayExtension();
        $config = $this->getEmptyConfig();
        $loader->load([$config], $this->configuration);

        $this->assertParameter('my_api_secret_key', 'quartet_webpay.api_secret');
        $this->assertParameter(null, 'quartet_webpay.api_base');
    }

    /**
     * @test
     */
    public function testOverrideApiBase()
    {
        $loader = new QuartetWebPayExtension();
        $config = $this->getEmptyConfig();
        $config['api_base'] = 'http://acme.com/';
        $loader->load([$config], $this->configuration);

        $this->assertParameter('http://acme.com/', 'quartet_webpay.api_base');
    }

    /**
     * @param $value
     * @param $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertSame($value, $this->configuration->getParameter($key));
    }

    /**
     * @return array
     */
    private function getEmptyConfig()
    {
        return array(
            'api_secret'    => 'my_api_secret_key'
        );
    }
}

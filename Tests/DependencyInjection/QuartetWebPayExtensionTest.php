<?php


namespace Quartet\Bundle\WebPayBundle\Tests\DependencyInjection;


use Quartet\Bundle\WebPayBundle\DependencyInjection\QuartetWebPayExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class QuartetWebPayExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var QuartetWebPayExtension
     */
    private $loader;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->loader = new QuartetWebPayExtension();
    }

    /**
     * @param array $configs
     */
    private function load(array $configs)
    {
        $this->loader->load([$configs], $this->container);
    }

    /**
     * @test
     * @dataProvider provideRequiredConfigurationNames
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testThrowExceptionUnlessConfigureRequired($requiredKey)
    {
        $config = $this->getEmptyConfig();
        unset($config[$requiredKey]);
        $this->load($config);
    }

    /**
     * @return array
     */
    public function provideRequiredConfigurationNames()
    {
        return [
            ['api_public'],
            ['api_secret'],
            ['test'],
        ];
    }

    /**
     * @test
     */
    public function testDefaultConfiguration()
    {
        $config = $this->getEmptyConfig();
        $this->load($config);

        $this->assertParameter('my_api_secret_key', 'quartet_webpay.api_secret');
        $this->assertParameter('my_api_public_key', 'quartet_webpay.api_public');
        $this->assertParameter(null, 'quartet_webpay.api_base');
        $this->assertParameter(false, 'quartet_webpay.test');
    }

    /**
     * @test
     */
    public function testOverrideApiBase()
    {
        $config = $this->getEmptyConfig();
        $config['api_base'] = 'http://acme.com/';
        $this->load($config);

        $this->assertParameter('http://acme.com/', 'quartet_webpay.api_base');
    }

    /**
     * @test
     */
    public function testWebPayServiceExists()
    {
        $config = $this->getEmptyConfig();
        $this->load($config);

        $this->assertHasDefinition('quartet_webpay_client');

        $webpay = $this->container->get('quartet_webpay_client');

        $this->assertInstanceOf('WebPay\WebPay', $webpay);
    }

    /**
     * @test
     */
    public function testSetAcceptLanguageIfConfigure()
    {
        $config = $this->getEmptyConfig();
        $config['accept_language'] = 'ja';
        $this->load($config);

        $this->assertHasDefinition('quartet_webpay_client');

        $definition = $this->container->getDefinition('quartet_webpay_client');
        $methodCalls = $definition->getMethodCalls();
        $this->assertCount(1, $methodCalls);
        $this->assertEquals(['acceptLanguage', ['ja']], $methodCalls[0]);
    }

    /**
     * @test
     */
    public function testTestConfig()
    {
        $config = $this->getEmptyConfig();
        $config['test'] = true;
        $this->load($config);

        $this->assertParameter(true, 'quartet_webpay.test');
    }

    /**
     * @test
     * @dataProvider provideInferTestModeTests
     * @param $expectedMode
     * @param $apiPublic
     */
    public function testInferTestMode($expectedMode, $apiPublic)
    {
        $config = $this->getEmptyConfig();
        $config['api_public'] = $apiPublic;
        unset($config['test']);

        $this->load($config);
        $this->assertParameter($expectedMode, 'quartet_webpay.test');
    }

    /**
     * @return array
     */
    public function provideInferTestModeTests()
    {
        return [
            [false, 'live_hoge'],
            [true, 'test_hoge'],
        ];
    }

    /**
     * @param $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue($this->container->hasDefinition($id));
    }

    /**
     * @param $value
     * @param $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertSame($value, $this->container->getParameter($key));
    }

    /**
     * @return array
     */
    private function getEmptyConfig()
    {
        return [
            'api_secret'    => 'my_api_secret_key',
            'api_public'    => 'my_api_public_key',
            'test'          => false,
        ];
    }
}

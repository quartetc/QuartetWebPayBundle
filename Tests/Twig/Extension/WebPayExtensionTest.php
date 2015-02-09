<?php

namespace Quartet\Bundle\WebPayBundle\Tests\Twig\Extension;

use Quartet\Bundle\WebPayBundle\Twig\Extension\WebPayExtension;

class WebPayExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider providePathTests
     * @param string $expectedPath
     * @param string $test
     * @param string $type
     * @param string $id
     * @param bool|null $runtimeTest
     * @param string $message
     */
    public function testPath($expectedPath, $test, $type, $id, $runtimeTest, $message = '')
    {
        $actualPath = $this->getTwig($test)->render('{{ webpay_path(type, id, test) }}', [
            'type' => $type,
            'id' => $id,
            'test' => $runtimeTest,
        ]);

        $this->assertEquals($expectedPath, $actualPath, $message);
    }

    /**
     * @return array
     */
    public function providePathTests()
    {
        return [
            ['https://webpay.jp/test/hoge/111', true, 'hoge', 111, null, 'Test mode'],
            ['https://webpay.jp/live/hoge/111', true, 'hoge', 111, false, 'Override test mode at runtime'],
            ['https://webpay.jp/live/hoge/111', false, 'hoge', 111, null, 'Live mode'],
            ['https://webpay.jp/test/hoge/111', false, 'hoge', 111, true, 'Override live mode at runtime'],
        ];
    }

    /**
     * @test
     * @dataProvider provideChargePathTests
     * @param string $expectedPath
     * @param string $test
     * @param string $id
     * @param bool|null $runtimeTest
     * @param string $message
     */
    public function testChargePath($expectedPath, $test, $id, $runtimeTest, $message = '')
    {
        $actualPath = $this->getTwig($test)->render('{{ webpay_charge_path(id, test) }}', [
            'id' => $id,
            'test' => $runtimeTest,
        ]);

        $this->assertEquals($expectedPath, $actualPath, $message);
    }

    /**
     * @return array
     */
    public function provideChargePathTests()
    {
        return [
            ['https://webpay.jp/test/charges/111', true, 111, null, 'Test mode'],
            ['https://webpay.jp/live/charges/111', true, 111, false, 'Override test mode at runtime'],
            ['https://webpay.jp/live/charges/111', false, 111, null, 'Live mode'],
            ['https://webpay.jp/test/charges/111', false, 111, true, 'Override live mode at runtime'],
        ];
    }


    /**
     * @test
     * @dataProvider provideCustomerPathTests
     * @param string $expectedPath
     * @param string $test
     * @param string $id
     * @param bool|null $runtimeTest
     * @param string $message
     */
    public function testCustomerPath($expectedPath, $test, $id, $runtimeTest, $message = '')
    {
        $actualPath = $this->getTwig($test)->render('{{ webpay_customer_path(id, test) }}', [
            'id' => $id,
            'test' => $runtimeTest,
        ]);

        $this->assertEquals($expectedPath, $actualPath, $message);
    }

    /**
     * @return array
     */
    public function provideCustomerPathTests()
    {
        return [
            ['https://webpay.jp/test/customers/111', true, 111, null, 'Test mode'],
            ['https://webpay.jp/live/customers/111', true, 111, false, 'Override test mode at runtime'],
            ['https://webpay.jp/live/customers/111', false, 111, null, 'Live mode'],
            ['https://webpay.jp/test/customers/111', false, 111, true, 'Override live mode at runtime'],
        ];
    }

    /**
     * @param bool $test
     * @return \Twig_Environment
     */
    private function getTwig($test)
    {
        $twig = new \Twig_Environment(new \Twig_Loader_String());
        $twig->addExtension(new WebPayExtension($test));

        return $twig;
    }
}

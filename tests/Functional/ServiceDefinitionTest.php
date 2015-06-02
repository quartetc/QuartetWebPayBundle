<?php


namespace Quartet\Bundle\WebPayBundle\Functional;



class ServiceDefinitionTest extends WebTestCase
{
    public function testAccessor()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $services = [
            'customers' => 'WebPay\Api\Customers',
            'account'   => 'WebPay\Api\Account',
            'tokens'    => 'WebPay\Api\Tokens',
            'events'    => 'WebPay\Api\Events',
            'charges'   => 'WebPay\Api\Charges',
        ];

        foreach ($services as $id => $class) {
            ;
            $this->assertInstanceOf($class, $container->get("quartet_webpay.{$id}"));
        }
    }
}

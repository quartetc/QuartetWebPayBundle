<?php

namespace Quartet\WebPayBundle\Tests\Session;


use Quartet\WebPayBundle\Model\Payment;
use Quartet\WebPayBundle\Session\PaymentManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class PaymentManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $manager = new PaymentManager(new Session(new MockArraySessionStorage()));

        $this->assertFalse($manager->has());
        $this->assertNull($manager->get());
        $this->assertNull($manager->remove());

        $payment = new Payment();
        $payment->setCard('card');
        $payment->setWillRegister(true);

        $manager->put($payment);

        $this->assertTrue($manager->has());
        $this->assertSame($payment, $manager->get());
        $this->assertSame($payment, $manager->remove());
        $this->assertFalse($manager->has());
        $this->assertNull($manager->get());
    }
}

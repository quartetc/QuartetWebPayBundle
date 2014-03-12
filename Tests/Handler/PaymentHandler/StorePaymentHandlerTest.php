<?php

namespace Quartet\WebPayBundle\Tests\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandler\StorePaymentHandler;

class StorePaymentHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testHandler()
    {
        $manager = $this->getMock('Quartet\WebPayBundle\Model\PaymentManagerInterface');

        $handler = new StorePaymentHandler($manager);

        $payment = $this->getMock('Quartet\WebPayBundle\Model\PaymentInterface');
        $user    = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $manager
            ->expects($this->once())
            ->method('put')
            ->with($payment);

        $handler->process($payment, $user);
    }
}

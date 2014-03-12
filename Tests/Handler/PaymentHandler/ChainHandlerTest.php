<?php

namespace Quartet\WebPayBundle\Tests\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandler\ChainHandler;

class ChainHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $user    = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
        $payment = $this->getMock('Quartet\WebPayBundle\Model\PaymentInterface');

        $handler1 = $this->getMock('Quartet\WebPayBundle\Handler\PaymentHandlerInterface');
        $handler1
            ->expects($this->once())
            ->method('handle')
            ->with($payment, $user);

        $handler2 = $this->getMock('Quartet\WebPayBundle\Handler\PaymentHandlerInterface');
        $handler2
            ->expects($this->once())
            ->method('handle')
            ->with($payment, $user);

        $handler = new ChainHandler(array($handler1, $handler2));
        $handler->process($payment, $user);
    }
}

<?php

namespace Quartet\WebPayBundle\Tests\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandler\StorePaymentHandler;

class StorePaymentHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $this->manager = $this->getMock('Quartet\WebPayBundle\Model\PaymentManagerInterface');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->manager = null;
    }

    /**
     * @test
     */
    public function testStorePayment()
    {
        $handler = new StorePaymentHandler($this->manager);

        $payment = $this->getPayment('card number');
        $user    = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $this->manager
            ->expects($this->once())
            ->method('put')
            ->with($payment);

        $handler->process($payment, $user);
    }

    /**
     * @test
     */
    public function testRemovePayment()
    {
        $handler = new StorePaymentHandler($this->manager);

        $payment = $this->getPayment(null);
        $user    = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $this->manager
            ->expects($this->once())
            ->method('remove');

        $handler->process($payment, $user);
    }

    private function getPayment($withCard)
    {
        $payment =$this->getMock('Quartet\WebPayBundle\Model\PaymentInterface');
        $payment
            ->expects($this->once())
            ->method('getCard')
            ->will($this->returnValue($withCard));

        return $payment;
    }
}

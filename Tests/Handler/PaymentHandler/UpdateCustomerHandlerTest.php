<?php

namespace Quartet\WebPayBundle\Tests\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandler\UpdateCustomerHandler;

class UpdateCustomerHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCustomerWillCreateWhenAlwaysPersistenceStrategy()
    {
        $user = $this->getUser();

        $action = $this->getWebPayAction();

        $action
            ->expects($this->once())
            ->method('execute')
            ->with(array(
                'card'  => 'hoge'
            ))
            ->will($this->returnCallback(function () {
                $data = new \stdClass();
                $data->id = 'registered customer id';
                return $data;
            }));

        $manager = $this->getCustomerManager();
        $manager
            ->expects($this->once())
            ->method('setCustomerId')
            ->with($user, 'registered customer id');

        $handler = new UpdateCustomerHandler($action, $manager, 'always');

        $handler->handle($this->getPayment('hoge', false), $user);
    }

    /**
     * @test
     */
    public function testCustomerWontCreateWhenNeverPersistenceStrategyRegardlessOfPaymentState()
    {
        $user = $this->getUser();
        $action = $this->getWebPayAction();
        $action->expects($this->never())->method('execute');

        $manager = $this->getCustomerManager();
        $manager->expects($this->never())->method('setCustomerId');

        $handler = new UpdateCustomerHandler($action, $manager, 'never');
        $handler->handle($this->getPayment('hoge', true), $user);
        $handler->handle($this->getPayment('hoge', false), $user);
    }

    /**
     * {@inheritdoc}
     */
    public function testCustomerWillCreateWhenOptionalPersistenceStrategy()
    {
        $user = $this->getUser();
        $action = $this->getWebPayAction();

        $action
            ->expects($this->once())
            ->method('execute')
            ->will($this->returnCallback(function () {
                $data = new \stdClass();
                $data->id = 'hoge';
                return $data;
            }));

        $manager = $this->getCustomerManager();
        $manager
            ->expects($this->once())
            ->method('setCustomerId');

        $handler = new UpdateCustomerHandler($action, $manager, 'optional');
        $handler->handle($this->getPayment('hoge', true), $user);
    }

    /**
     * {@inheritdoc}
     */
    public function testCustomerWontCreateWhenOptionalPersistenceStrategy()
    {
        $user = $this->getUser();
        $action = $this->getWebPayAction();
        $action->expects($this->never())->method('execute');

        $manager = $this->getCustomerManager();
        $manager->expects($this->never())->method('setCustomerId');

        $handler = new UpdateCustomerHandler($action, $manager, 'optional');
        $handler->handle($this->getPayment('hoge', false), $user);
    }

    private function getCustomerManager()
    {
        return $this->getMock('Quartet\WebPayBundle\Model\CustomerManagerInterface');
    }

    private function getWebPayAction($class = 'Quartet\WebPayBundle\WebPay\CreateCustomerAction')
    {
        return $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    private function getPayment($card, $willRegister)
    {
        $payment = $this->getMock('Quartet\WebPayBundle\Model\PaymentInterface');

        $payment
            ->expects($this->any())
            ->method('getCard')
            ->will($this->returnValue($card));

        $payment
            ->expects($this->any())
            ->method('getWillRegister')
            ->will($this->returnValue($willRegister));

        return $payment;
    }

    private function getUser()
    {
        return $this->getMock('FOS\UserBundle\Model\UserInterface');
    }

}

<?php

namespace Quartet\WebPayBundle\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandlerInterface;
use Quartet\WebPayBundle\Model\PaymentInterface;
use Quartet\WebPayBundle\Model\PaymentManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StorePaymentHandler implements PaymentHandlerInterface
{
    /**
     * @var \Quartet\WebPayBundle\Model\PaymentManagerInterface
     */
    private $manager;

    /**
     * @param PaymentManagerInterface $manager
     */
    public function __construct(PaymentManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(PaymentInterface $payment, UserInterface $user)
    {
        $this->manager->put($payment);
    }
}

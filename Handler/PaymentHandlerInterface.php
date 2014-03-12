<?php

namespace Quartet\WebPayBundle\Handler;


use Quartet\WebPayBundle\Model\PaymentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface PaymentHandlerInterface
{
    /**
     * @param PaymentInterface $payment
     * @param UserInterface    $user
     *
     * @return void
     */
    public function process(PaymentInterface $payment, UserInterface $user);
}

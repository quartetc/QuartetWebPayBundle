<?php

namespace Quartet\WebPayBundle\Session;


use Quartet\WebPayBundle\Model\PaymentInterface;
use Quartet\WebPayBundle\Model\PaymentManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PaymentManager extends AbstractSessionManager implements PaymentManagerInterface
{
    /**
     * @param Session $session
     * @param string  $key
     */
    public function __construct(Session $session, $key = '_quartet_webpay_payment_manager')
    {
        parent::__construct($session, $key);
    }

    /**
     * @param PaymentInterface $payment
     *
     * @return void
     */
    public function put(PaymentInterface $payment)
    {
        $this->setValue($payment);
    }

    /**
     * @return PaymentInterface
     */
    public function get()
    {
        return $this->getValue();
    }

    /**
     * @return boolean
     */
    public function has()
    {
        return $this->hasValue();
    }

    /**
     * @return PaymentInterface removed payment
     */
    public function remove()
    {
        return $this->removeValue();
    }
}

<?php

namespace Quartet\WebPayBundle\Session;


use Quartet\WebPayBundle\Model\PaymentInterface;
use Quartet\WebPayBundle\Model\PaymentManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PaymentManager implements PaymentManagerInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * @var string
     */
    private $key;

    /**
     * @param Session $session
     * @param string  $key
     */
    public function __construct(Session $session, $key = '_quartet_webpay_payment_manager')
    {
        $this->session = $session;
        $this->key     = $key;
    }

    /**
     * @param PaymentInterface $payment
     *
     * @return void
     */
    public function put(PaymentInterface $payment)
    {
        $this->session->set($this->generateKey(), $payment);
    }

    /**
     * @return PaymentInterface
     */
    public function get()
    {
        return $this->session->get($this->generateKey());
    }

    /**
     * @return boolean
     */
    public function has()
    {
        return $this->session->has($this->generateKey());
    }

    /**
     * @return PaymentInterface removed payment
     */
    public function remove()
    {
        return $this->session->remove($this->generateKey());
    }

    /**
     * @return string
     */
    private function generateKey()
    {
        return $this->key;
    }

}

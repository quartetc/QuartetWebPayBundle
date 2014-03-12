<?php

namespace Quartet\WebPayBundle\Model;


interface PaymentManagerInterface
{
    /**
     * @param PaymentInterface $payment
     *
     * @return void
     */
    public function put(PaymentInterface $payment);

    /**
     * @return PaymentInterface
     */
    public function get();

    /**
     * @return boolean
     */
    public function has();

    /**
     * @return PaymentInterface removed payment
     */
    public function remove();
}

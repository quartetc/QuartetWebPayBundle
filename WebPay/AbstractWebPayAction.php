<?php

namespace Quartet\WebPayBundle\WebPay;


use WebPay\WebPay;

abstract class AbstractWebPayAction implements WebPayActionInterface
{
    /**
     * @var \WebPay\WebPay
     */
    protected $webPay;

    /**
     * @param WebPay $webPay
     */
    public function __construct(WebPay $webPay)
    {
        $this->webPay = $webPay;
    }
}

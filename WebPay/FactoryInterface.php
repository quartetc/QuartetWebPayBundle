<?php

namespace Quartet\WebPayBundle\WebPay;


interface FactoryInterface
{
    /**
     * @param string $name
     *
     * @return WebPayActionInterface
     */
    public function getAction($name);
}

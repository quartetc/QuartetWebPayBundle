<?php

namespace Quartet\WebPayBundle\WebPay;


interface WebPayActionInterface
{
    /**
     * @param array $values
     *
     * @return mixed
     */
    public function execute(array $values);
}

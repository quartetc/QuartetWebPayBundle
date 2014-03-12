<?php

namespace Quartet\WebPayBundle\Model;


interface ChargeInterface
{
    /**
     * @return integer
     */
    public function getAmount();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return bool|null
     */
    public function getCapture();

    /**
     * @return integer|null
     */
    public function getExpireDays();

    /**
     * @return string|null
     */
    public function getUUID();
}

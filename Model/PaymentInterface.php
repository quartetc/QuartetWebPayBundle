<?php

namespace Quartet\WebPayBundle\Model;

interface PaymentInterface
{
    /**
     * @param array|string $card
     */
    public function setCard($card);

    /**
     * @return array|string
     */
    public function getCard();

    /**
     * @return boolean
     */
    public function getWillRegister();

    /**
     * @param boolean $willRegister
     */
    public function setWillRegister($willRegister);
}
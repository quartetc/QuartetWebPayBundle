<?php


namespace Quartet\WebPayBundle\Model;


class Payment implements PaymentInterface
{
    /**
     * @var string|array
     */
    private $card;

    /**
     * @var boolean
     */
    private $willRegister;

    /**
     * {@inheritdoc}
     */
    public function setCard($card)
    {
        $this->card = $card;
    }

    /**
     * {@inheritdoc}
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * {@inheritdoc}
     */
    public function setWillRegister($willRegister)
    {
        $this->willRegister = $willRegister;
    }

    /**
     * {@inheritdoc}
     */
    public function getWillRegister()
    {
        return $this->willRegister;
    }
}

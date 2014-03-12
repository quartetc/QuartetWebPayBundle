<?php


namespace Quartet\WebPayBundle\Session;


use Quartet\WebPayBundle\Model\ChargeInterface;
use Quartet\WebPayBundle\Model\ChargeManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;

class ChargeManager extends AbstractSessionManager implements ChargeManagerInterface
{
    /**
     * @param Session $session
     * @param string  $key
     */
    public function __construct(Session $session, $key = '_quartet_webpay_charge_manager')
    {
        parent::__construct($session, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function setCharge(ChargeInterface $charge)
    {
        $this->setValue($charge);
    }

    /**
     * {@inheritdoc}
     */
    public function getCharge()
    {
        return $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function hasCharge()
    {
        return $this->hasValue();
    }

    /**
     * {@inheritdoc}
     */
    public function removeCharge()
    {
        return $this->removeValue();
    }
}

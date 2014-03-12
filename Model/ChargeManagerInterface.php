<?php


namespace Quartet\WebPayBundle\Model;


use Symfony\Component\Security\Core\User\UserInterface;

interface ChargeManagerInterface
{
    /**
     * @param ChargeInterface $charge
     *
     * @return void
     */
    public function setCharge(ChargeInterface $charge);

    /**
     * @return ChargeInterface
     */
    public function getCharge();

    /**
     * @return bool
     */
    public function hasCharge();

    /**
     * @return ChargeInterface removed charge
     */
    public function removeCharge();
}

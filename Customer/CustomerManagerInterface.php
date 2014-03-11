<?php

namespace Quartet\WebPayBundle\Customer;


use Symfony\Component\Security\Core\User\UserInterface;

interface CustomerManagerInterface
{
    /**
     * @param UserInterface $user
     *
     * @return string
     */
    public function getCustomerId(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param string        $customerId
     *
     * @return void
     */
    public function setCustomerId(UserInterface $user, $customerId);
}
 
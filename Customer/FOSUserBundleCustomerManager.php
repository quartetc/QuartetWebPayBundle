<?php

namespace Quartet\WebPayBundle\Customer;


use FOS\UserBundle\Model\UserManagerInterface;
use Quartet\WebPayBundle\Model\CustomerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUserBundleCustomerManager implements CustomerManagerInterface
{
    /**
     * @var \FOS\UserBundle\Model\UserManagerInterface
     */
    private $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId(UserInterface $user)
    {
        if ($customer = $this->getCustomer($user)) {
            return $customer->getWebPayCustomerId();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerId(UserInterface $user, $customerId)
    {
        if ($customer = $this->getCustomer($user)) {
            $customer->setWebPayCustomerId($customerId);
            $this->userManager->updateUser($customer);
        }
    }

    /**
     * @param UserInterface $user
     *
     * @return CustomerInterface|null
     * @throws \LogicException
     */
    private function getCustomer(UserInterface $user)
    {
        if (!$user = $this->userManager->findUserByUsername($user->getUsername())) {
            return null;
        }

        if (!$user instanceof CustomerInterface) {
            throw new \LogicException(sprintf('Class %s should implement a interface "Quartet\WebPayBundle\Model\CustomerInterface"', get_class($user)));
        }

        return $user;
    }
}
 
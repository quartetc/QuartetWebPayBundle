<?php

namespace Quartet\WebPayBundle\Handler\PaymentHandler;


use Quartet\WebPayBundle\Model\CustomerManagerInterface;
use Quartet\WebPayBundle\Handler\PaymentHandlerInterface;
use Quartet\WebPayBundle\Model\PaymentInterface;
use Quartet\WebPayBundle\WebPay\CreateCustomerAction;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UpdateCustomerHandler implements PaymentHandlerInterface
{
    /**
     * @var \Quartet\WebPayBundle\Model\CustomerManagerInterface
     */
    private $customerManager;

    /**
     * @var \WebPay\WebPay
     */
    private $webPayAction;

    /**
     * @var string
     */
    private $persistence;

    /**
     * @param CreateCustomerAction     $webPayAction
     * @param CustomerManagerInterface $customerManager
     * @param string                   $persistence
     */
    public function __construct(CreateCustomerAction $webPayAction, CustomerManagerInterface $customerManager, $persistence)
    {
        $this->webPayAction     = $webPayAction;
        $this->customerManager  = $customerManager;
        $this->persistence      = $persistence;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(PaymentInterface $payment, UserInterface $user)
    {
        if ('never' === $this->persistence) {
            return;
        }

        if ('optional' === $this->persistence) {

            if (!$payment->getWillRegister()) {
                return;
            }

            $this->createAndUpdateCustomer($payment, $user);

            return;
        }

        if ('always' === $this->persistence) {

            $this->createAndUpdateCustomer($payment, $user);

            return;
        }

        throw new \RuntimeException(sprintf('Invalid persistence strategy "%s"', $this->persistence));
    }

    /**
     * @param PaymentInterface $payment
     * @param UserInterface    $user
     */
    private function createAndUpdateCustomer(PaymentInterface $payment, UserInterface $user)
    {
        $customer = $this->webPayAction->execute(array(
            'card'  => $payment->getCard(),
        ));

        $payment->setCard(null);

        $this->customerManager->setCustomerId($user, $customer->id);
    }
}

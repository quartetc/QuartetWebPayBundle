<?php

namespace Quartet\WebPayBundle\WebPay;


use Quartet\WebPayBundle\Model\ChargeManagerInterface;
use Quartet\WebPayBundle\Model\CustomerManagerInterface;
use Quartet\WebPayBundle\Model\PaymentManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WebPay\WebPay;

class CheckoutAction extends CreateChargeAction
{
    /**
     * @var \Quartet\WebPayBundle\Model\CustomerManagerInterface
     */
    private $customerManager;

    /**
     * @var \Quartet\WebPayBundle\Model\PaymentManagerInterface
     */
    private $paymentManager;

    /**
     * @param WebPay                  $webPay
     * @param ChargeManagerInterface  $chargeManager
     * @param PaymentManagerInterface $paymentManager
     */
    public function __construct(WebPay $webPay, CustomerManagerInterface $customerManager, PaymentManagerInterface $paymentManager)
    {
        parent::__construct($webPay);

        $this->customerManager = $customerManager;
        $this->paymentManager = $paymentManager;
    }

    /**
     * @param array $values
     *
     * @return mixed|\WebPay\Model\Charge
     * @throws \RuntimeException
     */
    public function executeAction(array $values)
    {
        if ($payment = $this->paymentManager->remove()) {
            $type = 'card';
            $payment = $payment->getCard();
        } elseif ($payment = $this->customerManager->getCustomerId($values['user'])) {
            $type = 'customer';
        } else {
            throw new \RuntimeException('cannot checkout');
        }

        return parent::executeAction(array(
            'charge'    => $values['charge'],
            'type'      => $type,
            'payment'   => $payment,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOption(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'charge', 'user',
            ))
            ->setAllowedTypes(array(
                'charge'    => 'Quartet\WebPayBundle\Model\ChargeInterface',
                'user'      => 'Symfony\Component\Security\Core\User\UserInterface',
            ))
        ;
    }
}

<?php

namespace Quartet\WebPayBundle\WebPay;


use Quartet\WebPayBundle\Model\ChargeInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateChargeAction extends AbstractWebPayAction
{
    /**
     * @param array $values
     *
     * @return mixed|\WebPay\Model\Charge
     */
    public function executeAction(array $values)
    {
        /* @var $charge ChargeInterface */
        $charge = $values['charge'];

        $options = array(
            'amount'        => $charge->getAmount(),
            'currency'      => $charge->getCurrency(),
            'description'   => $charge->getDescription(),
            'capture'       => $charge->getCapture(),
            'expire_days'   => $charge->getExpireDays(),
            'uuid'          => $charge->getUUID(),
        );

        $options[$values['type']] = $values['payment'];

        return $this->webPay->charges->create($options);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOption(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'charge', 'payment', 'type'
            ))
            ->setAllowedTypes(array(
                'charge'    => 'Quartet\WebPayBundle\Model\ChargeInterface',
                'payment'   => array('string', 'array'),
            ))
            ->setAllowedValues(array(
                'type'      => array('card', 'customer')
            ))
        ;
    }

}

<?php

namespace Quartet\WebPayBundle\WebPay;


use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateCustomerAction extends AbstractWebPayAction
{
    /**
     * {@inheritdoc}
     */
    public function executeAction(array $values)
    {
        return $this->webPay->customers->create($values);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOption(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array(
                'card', 'email', 'description', 'uuid'
            ))
        ;
    }
}

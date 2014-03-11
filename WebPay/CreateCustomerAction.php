<?php


namespace Quartet\WebPayBundle\WebPay;


class CreateCustomerAction extends AbstractWebPayAction
{
    /**
     * @param array $values
     *
     * @return mixed|\WebPay\Model\Customer
     */
    public function execute(array $values)
    {
        return $this->webPay->customers->create($values);
    }
}

<?php

namespace Quartet\WebPayBundle\WebPay;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WebPay\WebPay;

abstract class AbstractWebPayAction implements WebPayActionInterface
{
    /**
     * @var \WebPay\WebPay
     */
    protected $webPay;

    /**
     * @var \Symfony\Component\OptionsResolver\OptionsResolver
     */
    private $resolver;

    /**
     * @param WebPay $webPay
     */
    public function __construct(WebPay $webPay)
    {
        $this->webPay = $webPay;

        $this->setDefaultOption($this->resolver = new OptionsResolver());

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOption(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @param array $values
     *
     * @return mixed
     */
    final public function execute(array $values)
    {
        $values = $this->resolver->resolve($values);

        return $this->executeAction($values);
    }

    /**
     * @param array $values
     *
     * @return mixed
     */
    abstract public function executeAction(array $values);
}

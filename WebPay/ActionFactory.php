<?php

namespace Quartet\WebPayBundle\WebPay;


class ActionFactory implements FactoryInterface
{
    /**
     * @var WebPayActionInterface[]
     */
    private $actions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = array();
    }

    /**
     * @param string                $name
     * @param WebPayActionInterface $action
     */
    public function setAction($name, WebPayActionInterface $action)
    {
        $this->actions[$name] = $action;
    }

    /**
     * @param string $name
     *
     * @return WebPayActionInterface
     */
    public function getAction($name)
    {
        if (isset($this->actions[$name])) {
            return $this->actions[$name];
        }

        throw new \InvalidArgumentException(sprintf('The action "%s" does not found.', $name));
    }
}

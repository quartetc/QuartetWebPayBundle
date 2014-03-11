<?php

namespace Quartet\WebPayBundle\Form\Factory;


use Symfony\Component\Form\FormFactoryInterface;

abstract class AbstractFormFactory implements FactoryInterface
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected  $factory;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param FormFactoryInterface $factory
     * @param string               $name
     * @param string               $type
     * @param array                $options
     */
    public function __construct(FormFactoryInterface $factory, $name, $type, array $options = array())
    {
        $this->factory = $factory;
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function createForm($data = null)
    {
        return $this->factory->createNamed($this->name, $this->type, $data, $this->options);
    }
}

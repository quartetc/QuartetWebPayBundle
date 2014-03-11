<?php


namespace Quartet\WebPayBundle\Form\Factory;


use Symfony\Component\Form\FormFactoryInterface;

class PaymentFormFactory extends AbstractFormFactory
{
    /**
     * @param FormFactoryInterface $factory
     * @param string               $name
     * @param string               $type
     * @param boolean              $willUseTokenizer
     * @param boolean              $willShowPersistenceOption
     */
    public function __construct(FormFactoryInterface $factory, $name, $type, $willUseTokenizer, $willShowPersistenceOption)
    {
        parent::__construct($factory, $name, $type);

        $this->options['tokenize_payment'] = (boolean)$willUseTokenizer;
        $this->options['show_registration_option'] = (boolean)$willShowPersistenceOption;
    }
}

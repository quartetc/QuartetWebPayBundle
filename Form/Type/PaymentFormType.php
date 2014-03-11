<?php


namespace Quartet\WebPayBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentFormType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['tokenize_payment']) {
            $builder->add('card', 'quartet_webpay_token', array(
                'webpay_partial'    => true,
                'webpay_text'       => 'quartet_webpay.payment.text',
                'webpay_submit_text'=> 'quartet_webpay.payment.submit_text',
            ));
        } else {
        }

        if ($options['show_registration_option']) {
            $builder->add('will_register', 'checkbox', array(
                'label'     => 'quartet_webpay.payment.persistence',
                'required'  => false,
            ));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'tokenize_payment',
                'show_registration_option',
            ))
            ->setAllowedValues(array(
                'tokenize_payment'          => array(true, false),
                'show_registration_option'  => array(true, false),
            ))
            ->setDefaults(array(
                'tokenize_payment'          => true,
                'show_registration_option'  => true,
                'data_class'                => $this->class,
            ))
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quartet_webpay_payment';
    }
}
 
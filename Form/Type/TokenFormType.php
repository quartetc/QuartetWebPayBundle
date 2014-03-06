<?php

namespace Quartet\Bundle\WebPayBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TokenFormType extends AbstractType
{
    /**
     * @var string
     */
    private $publicApiKey;

    /**
     * @param string $publicApiKey
     */
    public function __construct($publicApiKey)
    {
        $this->publicApiKey = $publicApiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['webpay'] = array(
            'data-key'          => $this->publicApiKey,
            'data-token-name'   => $view->vars['full_name'],
        );

        if (array_key_exists('webpay_partial', $options)) {
            $view->vars['webpay']['data-partial'] = $options['webpay_partial'] ? 'true' : 'false';
        }

        if (array_key_exists('webpay_text', $options)) {
            $view->vars['webpay']['data-text'] = $options['webpay_text'];
        }

        if (array_key_exists('webpay_submit_text', $options)) {
            $view->vars['webpay']['data-submit-text'] = $options['webpay_submit_text'];
        }

        if ($options['webpay_previous_token']) {
            $view->vars['webpay']['webpay_previous_token'] = $view->vars['full_name'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'webpay_partial',
            'webpay_text',
            'webpay_submit_text',
            'webpay_previous_token'
        ));

        $resolver->setAllowedValues(array(
            'webpay_partial'   =>  array(
                true, false
            ),
            'webpay_previous_token' => array(
                true, false
            )
        ));

        $resolver->setDefaults(array(
            'webpay_previous_token' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'webpay_token';
    }
}
 
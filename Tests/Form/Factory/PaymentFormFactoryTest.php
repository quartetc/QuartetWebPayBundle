<?php

namespace Quartet\WebPayBundle\Tests\Form\Factory;


use Quartet\WebPayBundle\Form\Factory\PaymentFormFactory;

class PaymentFormFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCreateFormWithOptionsEnabled()
    {
        $factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createNamed')
            ->with('form_name', 'quartet_webpay_payment', array('hoge' => 'fuga'), array(
                'tokenize_payment'          => true,
                'show_registration_option'  => true,
            ));

        $factory = new PaymentFormFactory($factory, 'form_name', 'quartet_webpay_payment', true, true);

        $factory->createForm(array('hoge' => 'fuga'));
    }

    /**
     * @test
     */
    public function testCreateFormWithOptionsDisabled()
    {
        $factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $factory
            ->expects($this->once())
            ->method('createNamed')
            ->with('form_name', 'quartet_webpay_payment', array('hoge' => 'fuga'), array(
                'tokenize_payment'          => false,
                'show_registration_option'  => false,
            ));

        $factory = new PaymentFormFactory($factory, 'form_name', 'quartet_webpay_payment', false, false);

        $factory->createForm(array('hoge' => 'fuga'));
    }
}
 
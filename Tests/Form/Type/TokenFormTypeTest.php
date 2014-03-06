<?php

namespace Quartet\Bundle\WebPayBundle\Tests\Form\Type;


use Quartet\Bundle\WebPayBundle\Form\Type\TokenFormType;
use Symfony\Component\Form\Test\TypeTestCase;

class TokenFormTypeTest extends TypeTestCase
{
    /**
     * @var TokenFormType
     */
    private $type;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->type = new TokenFormType('public-api-key');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->type = null;
    }

    /**
     * @test
     */
    public function testParentSet()
    {
        $this->assertSame('hidden', $this->type->getParent());
    }

    /**
     * @test
     */
    public function testNameSet()
    {
        $this->assertSame('webpay_token', $this->type->getName());
    }

    /**
     * @test
     */
    public function testPassDefaultOptions()
    {
        $view = $this->factory->create($this->type)->createView();

        $this->assertNotEmpty($view->vars['webpay']);
        $this->assertSame(array(
            'data-key'              => 'public-api-key',
            'data-token-name'       => 'webpay_token',
        ), $view->vars['webpay']);
    }

    /**
     * @test
     */
    public function testDataTokenNameInSubForm()
    {
        $view = $this->factory->createBuilder('form')
            ->add('hoge', 'text')
            ->add('token', $this->type)
            ->getForm()
            ->createView();

        $this->assertSame('form[token]', $view->vars['form']['token']->vars['webpay']['data-token-name']);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testThrowExceptionPassNotAllowedValueToPartial()
    {
        $this->factory->create($this->type, null, array(
            'webpay_partial'    => 'a'
        ));
    }

    /**
     * @test
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testThrowExceptionPassNotAlloedValueToPreviousToken()
    {
        $this->factory->create($this->type, null, array(
            'webpay_previous_token' => 'a'
        ));
    }

    /**
     * @test
     */
    public function testPassOptions()
    {
        $view = $this->factory->create($this->type, null, array(
            'webpay_partial'        => false,
            'webpay_text'           => 'hoge',
            'webpay_submit_text'    => 'fuga',
            'webpay_previous_token' => true,
        ))->createView();

        $this->assertNotEmpty($view->vars['webpay']);
        $this->assertSame(array(
            'data-key'              => 'public-api-key',
            'data-token-name'       => 'webpay_token',
            'data-partial'          => 'false',
            'data-text'             => 'hoge',
            'data-submit-text'      => 'fuga',
            'webpay_previous_token' => 'webpay_token',
        ), $view->vars['webpay']);
    }
}
 
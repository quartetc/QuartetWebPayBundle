<?php


namespace Quartet\Bundle\WebPayBundle\Tests\DependencyInjection\Compiler;


use Quartet\Bundle\WebPayBundle\DependencyInjection\Compiler\FormPass;

class FormPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testAddContainerParameter()
    {
        $pass = new FormPass();

        $builder = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        $builder
            ->expects($this->at(0))
            ->method('getParameter')
            ->with('twig.form.resources')
            ->will($this->returnValue(array('hoge', 'fuga')));

        $builder
            ->expects($this->at(1))
            ->method('getParameter')
            ->with('quartet_webpay.form.templating')
            ->will($this->returnValue('piyo'));

        $builder
            ->expects($this->once())
            ->method('setParameter')
            ->with('twig.form.resources', array('hoge', 'fuga', 'piyo'))
        ;

        $pass->process($builder);
    }
}

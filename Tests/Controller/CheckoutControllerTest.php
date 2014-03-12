<?php

namespace Quartet\WebPayBundle\Tests\Controller;


use Quartet\WebPayBundle\Controller\CheckoutController;
use Quartet\WebPayBundle\Form\Type\PaymentFormType;
use Quartet\WebPayBundle\Form\Type\TokenFormType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class CheckoutControllerTest extends WebTestCase
{
    /**
     * @var CheckoutController
     */
    private $controller;

    /**
     * @var Container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->controller = new CheckoutController();

        $this->container = new Container();

        $this->controller->setContainer($this->container);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->container = null;
        $this->controller = null;
    }

    /**
     * @test
     */
    public function testBuildSecurityContextWithUser()
    {
        $securityContext = $this->buildSecurityContextWithUser(null);
        $this->assertNull($securityContext->getToken()->getUser());

        $securityContext = $this->buildSecurityContextWithUser(12345);
        $this->assertSame(12345, $securityContext->getToken()->getUser());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testThrowExceptionUnlessAuthenticationIn()
    {
        $securityContext = $this->buildSecurityContextWithUser(null);

        $this->container->set('security.context', $securityContext);

        $this->controller->indexAction();
    }

    /**
     * @test
     */
    public function testIndexActionRespondRedirectionToPaymentActionWithNonCustomer()
    {
        $this->setSecurityContextWithUser($user = $this->getUser());

        $customerManager = $this->getMock('Quartet\WebPayBundle\Model\CustomerManagerInterface');
        $customerManager
            ->expects($this->any())
            ->method('getWebPayCustomerId')
            ->with($user)
            ->will($this->returnValue(null));

        $this->container->set('quartet_webpay.customer_manager', $customerManager);

        $router = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $router
            ->expects($this->once())
            ->method('generate')
            ->with('quartet_webpay_checkout_payment')
            ->will($this->returnValue('hoge'));

        $this->container->set('router', $router);

        $response = $this->controller->indexAction();
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
        $this->assertSame('hoge', $response->getTargetUrl());
    }

    /**
     * @test
     */
    public function testIndexActionRespondRedirectToConfirmActionWithCustomer()
    {
        $this->setSecurityContextWithUser($user = $this->getUser());

        $customerManager = $this->getMock('Quartet\WebPayBundle\Model\CustomerManagerInterface');
        $customerManager
            ->expects($this->any())
            ->method('getCustomerId')
            ->with($user)
            ->will($this->returnValue(30));

        $this->container->set('quartet_webpay.customer_manager', $customerManager);

        $router = $this->getMock('Symfony\Component\Routing\RouterInterface');
        $router
            ->expects($this->once())
            ->method('generate')
            ->with('quartet_webpay_checkout_confirm')
            ->will($this->returnValue('hoge'));

        $this->container->set('router', $router);

        $response = $this->controller->indexAction();
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $response);
        $this->assertSame('hoge', $response->getTargetUrl());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testThrowExceptionUnlessAuthenticationInPaymentAction()
    {
        $this->setSecurityContextWithUser();

        $this->controller->paymentAction(new Request());
    }

    /**
     * @param UserInterface $user
     */
    private function setSecurityContextWithUser(UserInterface $user = null)
    {
        $this->container->set('security.context', $this->buildSecurityContextWithUser($user));
    }

    /**
     * @param $user
     *
     * @return SecurityContextInterface
     */
    private function buildSecurityContextWithUser($user)
    {

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token
            ->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($user));

        $securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $securityContext
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($token));

        return $securityContext;
    }

    /**
     * @return UserInterface
     */
    private function getUser($username = 'user')
    {
        $user = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $user
            ->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue($username));

        return $user;
    }

}

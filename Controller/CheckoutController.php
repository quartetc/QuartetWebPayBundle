<?php

namespace Quartet\WebPayBundle\Controller;


use Quartet\WebPayBundle\Form\Factory\FactoryInterface;
use Quartet\WebPayBundle\Model\CustomerManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CheckoutController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUserOrThrowException();

        /** @var $customerManager CustomerManagerInterface */
        $customerManager = $this->get('quartet_webpay.customer_manager');

        if ($customerId = $customerManager->getCustomerId($user)) {
            return $this->redirect($this->generateUrl('quartet_webpay_checkout_confirm'));
        } else {
            return $this->redirect($this->generateUrl('quartet_webpay_checkout_payment'));
        }
    }

    public function paymentAction(Request $request)
    {
        $user = $this->getUserOrThrowException();

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('quartet_webpay.checkout.payment.form_factory');

        $form = $formFactory->createForm();

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $payment = $form->getData();

                $this->get('quartet_webpay.checkout.payment_handler')->process($payment, $user);

                return $this->redirect($this->generateUrl('quartet_webpay_checkout_confirm'));
            }
        }

        return $this->render('QuartetWebPayBundle:Checkout:payment.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    public function confirmAction(Request $request)
    {
        $user = $this->getUserOrThrowException();
        $this->ensureAbleToCheckoutOrThrowException();

        if ('POST' === $request->getMethod()) {

            $charge = $this->get('quartet_webpay.checkout.charge_manager')->removeCharge($user);

            $actionFactory = $this->get('quartet_webpay.action.factory');

            $action = $actionFactory->getAction('checkout');

            $action->execute(array(
                'user'      => $user,
                'charge'    => $charge,
            ));

            return $this->redirect($this->generateUrl('quartet_webpay_checkout_confirmed'));
        }

        $form = $this->createForm('form');

        $charge = $this->get('quartet_webpay.checkout.charge_manager')->getCharge();

        return $this->render('QuartetWebPayBundle:Checkout:confirm.html.twig', array(
            'form'      => $form->createView(),
            'charge'    => $charge,
        ));
    }

    public function confirmedAction()
    {
        return $this->render('QuartetWebPayBundle:Checkout:confirmed.html.twig', array(

        ));
    }

    /**
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    private function ensureAbleToCheckoutOrThrowException()
    {
        $chargeManager = $this->get('quartet_webpay.checkout.charge_manager');

        if (!$chargeManager->hasCharge()) {
            throw new BadRequestHttpException;
        }

        $user = $this->getUserOrThrowException();

        $customerManager = $this->get('quartet_webpay.customer_manager');
        $paymentManager = $this->get('quartet_webpay.checkout.payment_manager');

        if (!$customerManager->getCustomerId($user) && !$paymentManager->has()) {
            throw new BadRequestHttpException;
        }
    }

    /**
     * @return mixed
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    private function getUserOrThrowException()
    {
        if (!$user = $this->getUser()) {
            throw new AccessDeniedException;
        }
        return $user;
    }
}

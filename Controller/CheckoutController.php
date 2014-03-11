<?php

namespace Quartet\WebPayBundle\Controller;


use Quartet\WebPayBundle\Customer\CustomerManagerInterface;
use Quartet\WebPayBundle\Form\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

                return $this->redirect($this->generateUrl('quartet_webpay_checkout_confirm'));
            }
        }

        return $this->render('QuartetWebPayBundle:Checkout:payment.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    public function confirmAction()
    {

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

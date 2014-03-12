<?php


namespace Quartet\WebPayBundle\Handler\PaymentHandler;


use Quartet\WebPayBundle\Handler\PaymentHandlerInterface;
use Quartet\WebPayBundle\Model\PaymentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ChainHandler implements PaymentHandlerInterface
{
    /**
     * @var PaymentHandlerInterface[]
     */
    private $handlers;

    /**
     * @param PaymentHandlerInterface[] $handlers
     */
    public function __construct(array $handlers = array())
    {
        $this->handlers = $handlers;
    }

    /**
     * {@inheritdoc}
     */
    public function process(PaymentInterface $payment, UserInterface $user)
    {
        foreach ($this->handlers as $handler) {
            $handler->process($payment, $user);
        }
    }
}

<?php

namespace Quartet\WebPayBundle\Session;

use Symfony\Component\HttpFoundation\Session\Session;

abstract class AbstractSessionManager
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * @var string
     */
    private $key;

    /**
     * @param Session $session
     * @param string  $key
     */
    public function __construct(Session $session, $key = null)
    {
        $this->session = $session;
        $this->key     = $key;
    }

    /**
     * @param mixed $value
     */
    protected function setValue($value)
    {
        $this->session->set($this->generateKey(), $value);
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->session->get($this->generateKey());
    }

    /**
     * @return bool
     */
    protected function hasValue()
    {
        return $this->session->has($this->generateKey());
    }

    /**
     * @return mixed
     */
    protected function removeValue()
    {
        return $this->session->remove($this->generateKey());
    }

    /**
     * @param $object
     *
     * @return string
     */
    protected function generateKey()
    {
        return $this->key;
    }
}

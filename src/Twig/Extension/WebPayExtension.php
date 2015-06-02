<?php

namespace Quartet\Bundle\WebPayBundle\Twig\Extension;

class WebPayExtension extends \Twig_Extension
{
    /**
     * @var bool
     */
    private $test;

    /**
     * @param bool $test
     */
    public function __construct($test)
    {
        $this->test = $test;
    }

    /**
     * @param string $type
     * @param string $id
     * @param bool $test
     * @return string
     */
    public function path($type, $id, $test = null)
    {
        if ($test === null) {
            $test = $this->test;
        }

        $mode = $test ? 'test' : 'live';

        return sprintf('https://webpay.jp/%s/%s/%s', $mode, $type, $id);
    }

    /**
     * @param string $id
     * @param bool $test
     * @return string
     */
    public function chargePath($id, $test = null)
    {
        return $this->path('charges', $id, $test);
    }

    /**
     * @param string $id
     * @param bool $test
     * @return string
     */
    public function customerPath($id, $test = null)
    {
        return $this->path('customers', $id, $test);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('webpay_path', [$this, 'path']),
            new \Twig_SimpleFunction('webpay_charge_path', [$this, 'chargePath']),
            new \Twig_SimpleFunction('webpay_customer_path', [$this, 'customerPath']),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quartet_webpay';
    }
}

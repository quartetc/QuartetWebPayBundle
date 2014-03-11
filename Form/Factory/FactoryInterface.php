<?php

namespace Quartet\WebPayBundle\Form\Factory;


use Symfony\Component\Form\FormInterface;

interface FactoryInterface
{
    /**
     * @param mixed $data
     *
     * @return FormInterface
     */
    public function createForm($data = null);
}
 
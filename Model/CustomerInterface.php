<?php

namespace Quartet\WebPayBundle\Model;


interface CustomerInterface
{
    /**
     * @param string $webPayCustomerId
     *
     * @return void
     */
    public function setWebPayCustomerId($webPayCustomerId);

    /**
     * @return string
     */
    public function getWebPayCustomerId();
}
 
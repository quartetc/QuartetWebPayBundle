<?php

namespace Quartet\WebPayBundle\Tests\Session;


use Quartet\WebPayBundle\Session\ChargeManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ChargeManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test()
    {
        $manager = new ChargeManager(new Session(new MockArraySessionStorage()));

        $this->assertFalse($manager->hasCharge());
        $this->assertNull($manager->getCharge());
        $this->assertNull($manager->removeCharge());

        $charge = $this->getCharge();

        $manager->setCharge($charge);

        $this->assertTrue($manager->hasCharge());
        $this->assertSame($charge, $manager->getCharge());
        $this->assertSame($charge, $manager->removeCharge());
        $this->assertFalse($manager->hasCharge());
        $this->assertNull($manager->getCharge());
    }

    private function getCharge()
    {
        $charge = $this->getMock('Quartet\WebPayBundle\Model\ChargeInterface');

        return $charge;
    }
}

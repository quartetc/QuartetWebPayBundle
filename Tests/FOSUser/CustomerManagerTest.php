<?php


namespace Quartet\WebPayBundle\Tests\Customer;


use Quartet\WebPayBundle\FOSUser\CustomerManager;

class CustomerManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \LogicException
     */
    public function testThrowExceptionUnlessUserImplementCustomerInterface()
    {
        $username = 'hoge';
        $user = $this->getUser($username);

        $fos = $this->getMock('FOS\UserBundle\Model\UserManagerInterface');

        $fos->expects($this->any())
            ->method('findUserByUsername')
            ->with($username)
            ->will($this->returnValue($user));

        $manager = new CustomerManager($fos);

        $manager->getCustomerId($user);
    }

    /**
     * @test
     */
    public function testReturnNullUnlessUserFound()
    {
        $fos = $this->getFosUserManager(null);
        $manager = new CustomerManager($fos);

        $this->assertNull($manager->getCustomerId($this->getUser('hoge')));
    }

    /**
     * @test
     */
    public function testGetCustomerId()
    {
        $customer = $this->getCustomer();
        $customer
            ->expects($this->atLeastOnce())
            ->method('getWebPayCustomerId')
            ->will($this->returnValue(30));

        $fos = $this->getFosUserManager($customer);

        $manager = new CustomerManager($fos);
        $this->assertSame(30, $manager->getCustomerId($this->getUser('hoge')));
    }

    private function getFosUserManager($user)
    {
        $fos = $this->getMock('FOS\UserBundle\Model\UserManagerInterface');

        $fos->expects($this->any())
            ->method('findUserByUsername')
            ->will($this->returnValue($user));

        return $fos;
    }

    private function getCustomer()
    {
        $customer = $this->getMock('Quartet\WebPayBundle\Model\CustomerInterface');

        return $customer;
    }

    private function getUser($username)
    {
        $user = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $user
            ->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue($username));

        return $user;
    }

}

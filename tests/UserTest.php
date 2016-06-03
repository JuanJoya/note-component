<?php

use Note\Domain\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    function test_create_user()
    {
        $user = new User('juan@pc.co', '12345');

        $this->assertInstanceOf(User::class, $user);
    }

    function test_user_name()
    {
        $user = new User('juan@pc.co', '12345');

        $user->setName('juan', 'joya');

        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();

        $this->assertEquals('juan', $firstName);
        $this->assertEquals('joya', $lastName);
    }

    function test_user_create_fail()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $user = new User('juan@','');
    }
}

<?php

use Note\Domain\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    function test_create_user()
    {
        $user = new User('juan@pc.co', '12345');
        $this->assertInstanceOf(User::class, $user);
    }

    function test_user_create_fail()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $user = new User('juan@','');
    }

    function test_get_data()
    {
        $user = new User('juan@pc.co', '12345');
        $user->setName('juan', 'joya');

        $this->assertEquals('juan', $user->getFirstName());
        $this->assertEquals('joya', $user->getLastName());
    }
}

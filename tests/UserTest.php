<?php

namespace tests;

use app\service\UserService;
use tests\TestCase;

class UserTest extends TestCase
{
    public function test()
    {
        /**
         * @var UserService
         */
        $user = $this->container->get(UserService::class);

        $this->assertNotNull($user);
    }
}

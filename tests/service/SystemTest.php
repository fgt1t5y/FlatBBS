<?php

namespace tests;

use app\service\SystemService;
use tests\TestCase;

class SystemTest extends TestCase
{
    public function test()
    {
        /**
         * @var SystemService
         */
        $system = $this->container->get(SystemService::class);

        $this->assertIsArray($system->getRedisServerInfo());
        $this->assertNotNull($system->getPhpVersion());
        $this->assertEquals($system->getDatabaseDriver(), 'mysql');
    }
}

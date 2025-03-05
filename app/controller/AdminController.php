<?php

namespace app\controller;

use support\Request;
use app\service\SystemService;
use DI\Attribute\Inject;

class AdminController
{
    #[Inject]
    protected SystemService $system;

    public function sysinfo(Request $request)
    {
        $data = [
            'redis_version' => $this->system->getRedisServerInfo()['redis_version'],
            'php_version' => $this->system->getPhpVersion(),
            'database_driver' => $this->system->getDatabaseDriver(),
            'database_version' => $this->system->getDatabaseVersion()
        ];

        return ok($data);
    }
}

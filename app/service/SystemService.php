<?php

namespace app\service;

use support\Redis;
use support\Db;

class SystemService
{
    public function getRedisServerInfo()
    {
        /**
         * @var string
         */
        $infoRaw = Redis::rawCommand('INFO', 'server');
        $infoLines = explode("\r\n", $infoRaw);

        array_shift($infoLines);

        $kvArray = [];

        foreach ($infoLines as $line) {
            if (empty($line)) {
                continue;
            }
            $kv = explode(':', $line);
            $kvArray[$kv[0]] = $kv[1];
        }

        return $kvArray;
    }

    public function getPhpVersion()
    {
        return PHP_VERSION;
    }

    public function getDatabaseDriver()
    {
        return Db::connection()->getDriverName();
    }

    public function getDatabaseVersion()
    {
        return Db::connection()->selectOne('select version() as version')->version;
    }
}

<?php

namespace support;

use InvalidArgumentException;
use Webman\Bootstrap;
use Workerman\Worker;
use app\interface\FilesystemBuilder;

class Storage implements Bootstrap
{
    private static array $filesystemConfig = [];

    private static array $storageConfig = [];

    private static bool $inited = false;

    public static function start(?Worker $worker)
    {
        self::$filesystemConfig = config('fs');
        self::$storageConfig = config('storage');
    }

    public static function use(string $storage)
    {
        $storageConfig = self::$storageConfig[$storage];

        if (!$storageConfig) {
            throw new InvalidArgumentException("Storage $storage not found");
        }

        $filesystem = $storageConfig['filesystem'];
        /**
         * @var FilesystemBuilder $builder
         */
        $builder = self::$filesystemConfig[$filesystem];

        return $builder::build($storageConfig['config']);
    }

    public static function getStorageRoot(string $storage): string
    {
        $storageConfig = self::$storageConfig[$storage];

        if (!$storageConfig) {
            throw new InvalidArgumentException("Storage $storage not found");
        }

        return $storageConfig['config']['root'];
    }
}

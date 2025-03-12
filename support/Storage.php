<?php

namespace support;

use InvalidArgumentException;
use app\interface\FilesystemBuilder;

class Storage
{
    private static array $filesystemConfig = [];

    private static array $storageConfig = [];

    private static bool $inited = false;

    public static function init()
    {
        self::$filesystemConfig = config('fs');
        self::$storageConfig = config('storage');
        self::$inited = true;
    }

    public static function use(string $storage)
    {
        if (!self::$inited) {
            self::init();
        }

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
        if (!self::$inited) {
            self::init();
        }

        $storageConfig = self::$storageConfig[$storage];

        if (!$storageConfig) {
            throw new InvalidArgumentException("Storage $storage not found");
        }

        return $storageConfig['config']['root'];
    }
}

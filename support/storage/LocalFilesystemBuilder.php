<?php

namespace support\storage;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use app\interface\FilesystemBuilder;

class LocalFilesystemBuilder implements FilesystemBuilder
{
    public static function build(array $config): Filesystem
    {
        return new Filesystem(new LocalFilesystemAdapter(
            $config['root'],
            null,
            LOCK_EX,
            LocalFilesystemAdapter::DISALLOW_LINKS
        ), ['public_url' => $config['endpoint']]);
    }
}

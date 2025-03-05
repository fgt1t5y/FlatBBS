<?php

namespace app\interface;

use League\Flysystem\Filesystem;

interface FilesystemBuilder
{
    public static function build(array $config): Filesystem;
}

<?php

namespace app\service;

use app\interface\FilesystemBuilder;
use Aws\S3\S3Client;
use InvalidArgumentException;

class StorageService
{
    private ?S3Client $s3Client = null;

    public function use(string $storage)
    {
        $storageConfig = config("storage.$storage");

        if (!$storageConfig) {
            throw new InvalidArgumentException("Storage $storage not found");
        }

        $filesystem = $storageConfig['filesystem'];
        /**
         * @var FilesystemBuilder $builder
         */
        $builder = config("fs.$filesystem");

        return $builder::build($storageConfig['config']);
    }

    public function getStorageRoot(string $storage): string
    {
        $storageConfig = config("storage.$storage");

        if (!$storageConfig) {
            throw new InvalidArgumentException("Storage $storage not found");
        }

        return $storageConfig['config']['root'];
    }
}

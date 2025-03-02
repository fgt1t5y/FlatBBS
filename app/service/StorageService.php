<?php

namespace app\service;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Aws\S3\S3Client;

class StorageService
{
    private S3Client $s3Client;

    public function useLocal()
    {
        return new Filesystem(new LocalFilesystemAdapter(
            config('fs.local.path'),
            null,
            LOCK_EX,
            LocalFilesystemAdapter::DISALLOW_LINKS
        ));
    }

    public function useS3()
    {
        return new Filesystem(
            new AwsS3V3Adapter($this->getS3Client(), config('fs.s3.bucket'))
        );
    }

    public function createS3Client()
    {
        $this->s3Client = new S3Client([
            'credentials' => [
                'key' => config('fs.s3.key'),
                'secret' => config('fs.s3.secret'),
            ],
            'region' => config('fs.s3.region'),
            'version' => 'latest',
            'endpoint' => config('fs.s3.endpoint'),
        ]);

        return $this->s3Client;
    }

    public function getS3Client()
    {
        if ($this->s3Client) {
            return $this->s3Client;
        } else {
            return $this->createS3Client();
        }
    }
}

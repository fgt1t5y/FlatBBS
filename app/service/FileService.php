<?php

namespace app\service;

use Intervention\Image\Exception\ImageException;
use Intervention\Image\ImageManager;
use Webman\Http\UploadFile;

class FileService
{
    private $supportedFile = ['image/png', 'image/jpeg'];

    public function upload(UploadFile|array $files, bool|null $with_suffix = false): array|null
    {
        $filenames = [];
        $filename = '';

        if (!$files) {
            return null;
        }

        // 单个文件时 file 是 object，将其转换为 array 才可以 foreach
        if (is_object($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (!in_array($file->getUploadMimeType(), $this->supportedFile)) {
                return null;
            }

            $filename = random_string() . '.jpg';
            $path = config_with('flatbbs.paths.usercontent', $filename);

            try {
                $image = (ImageManager::gd())->read($file->getPathname());
                $image->save($path, 60, 'jpg');
            } catch (ImageException) {
                return null;
            }
            
            if ($with_suffix) {
                $filenames[] = "/backend/usercontent/{$filename}";
            } else {
                $filenames[] = $filename;
            }
        }

        return $filenames;
    }
}

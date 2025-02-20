<?php

namespace app\service;

use Intervention\Image\Exception\ImageException;
use Intervention\Image\ImageManager;
use Webman\Http\UploadFile;
use Illuminate\Support\Str;

class FileService
{
    private $supportedFile = ['image/png', 'image/jpeg'];

    public function upload(UploadFile $file, ?bool $with_suffix = false): string|null
    {
        $filename = '';

        if (
            !$file ||
            !in_array($file->getUploadMimeType(), $this->supportedFile)
        ) {
            return null;
        }

        $filename = Str::random() . '.jpg';
        $path = config_with('flatbbs.paths.usercontent', $filename);

        try {
            $image = (ImageManager::gd())->read($file->getPathname());
            $image->save($path, 60, 'jpg');
        } catch (ImageException) {
            return null;
        }

        if ($with_suffix) {
            $filename = "/backend/usercontent/{$filename}";
        }

        return $filename;
    }
}

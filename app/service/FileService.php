<?php

namespace app\service;

use Intervention\Image\Exception\ImageException;
use Intervention\Image\ImageManager;
use Webman\Http\UploadFile;
use Illuminate\Support\Str;

class FileService
{
    private $supportedFile = ['image/png', 'image/jpeg'];

    public function uploadImage(UploadFile $file, ?bool $with_suffix = false): string|null
    {
        $filename = '';

        if (
            !$file ||
            !in_array($file->getUploadMimeType(), $this->supportedFile)
        ) {
            return null;
        }

        $filename = Str::random();
        $base_path = config('flatbbs.paths.usercontent');
        $manager = ImageManager::gd();

        try {
            $image = $manager->read($file->getPathname());
            if ($image->isAnimated()) {
                $filename .= '.gif';
                $image->save("{$base_path}{$filename}", 100, 'gif');
            } else {
                $filename .= '.jpg';
                $image->save("{$base_path}{$filename}", 80, 'jpg');
            }
        } catch (ImageException) {
            return null;
        }

        if ($with_suffix) {
            $filename = "/backend/usercontent/{$filename}";
        }

        return $filename;
    }
}

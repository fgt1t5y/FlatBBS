<?php

namespace app\service;

use Intervention\Image\Exception\ImageException;
use Intervention\Image\ImageManager;
use Webman\Http\UploadFile;
use Illuminate\Support\Str;

class FileService
{
    public function saveUserAvatar(UploadFile $file): ?string
    {
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

        return $filename;
    }
}

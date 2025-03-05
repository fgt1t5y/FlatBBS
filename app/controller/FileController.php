<?php

namespace app\controller;

use DI\Attribute\Inject;
use support\Request;
use app\service\FileService;
use app\service\SettingService;
use app\service\StorageService;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class FileController
{
    #[Inject]
    protected FileService $file;

    #[Inject]
    protected SettingService $setting;

    #[Inject]
    protected StorageService $storage;

    public function image(Request $request)
    {
        $request->assertLogin();

        $file = $request->file('avgfile');

        if (!$file) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        if (
            !in_array(
                $file->getUploadMimeType(),
                $this->setting->getArrayValue('allowedImageType')
            )
        ) {
            return no(STATUS_BAD_REQUEST, '$exception.invalid_file_type');
        }

        $filename = Str::random();
        $base_path = $this->storage->getStorageRoot('user-content');
        $manager = ImageManager::gd();

        try {
            $image = $manager->read($file->getPathname());
            if ($image->isAnimated()) {
                $filename .= '.gif';
                $image->save("{$base_path}/{$filename}", 100, 'gif');
            } else {
                $filename .= '.jpg';
                $image->save("{$base_path}/{$filename}", 80, 'jpg');
            }
        } catch (\Throwable $e) {
            return no(STATUS_INTERNAL_ERROR, $e->getMessage());
        }

        return ok($this->storage->use('user-content')->publicUrl($filename));
    }
}

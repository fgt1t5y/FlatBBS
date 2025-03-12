<?php

namespace app\controller;

use DI\Attribute\Inject;
use support\Request;
use app\service\SettingService;
use app\service\StorageService;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class FileController
{
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
        $basePath = $this->storage->getStorageRoot('user-content');

        try {
            $image = ImageManager::gd()->read($file->getPathname());

            if ($image->isAnimated()) {
                $filename .= '.gif';
                $image->save("{$basePath}/{$filename}", 100, 'gif');
            } else {
                $filename .= '.jpg';
                $image->save("{$basePath}/{$filename}", 80, 'jpg');
            }
        } catch (\Throwable $e) {
            return no(STATUS_INTERNAL_ERROR, $e->getMessage());
        }

        return ok($this->storage->use('user-content')->publicUrl($filename));
    }
}

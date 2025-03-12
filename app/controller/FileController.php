<?php

namespace app\controller;

use support\Request;
use support\Storage;
use DI\Attribute\Inject;
use app\service\SettingService;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class FileController
{
    #[Inject]
    protected SettingService $setting;

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
        $basePath = Storage::getStorageRoot('user-content');

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

        return ok(Storage::use('user-content')->publicUrl($filename));
    }
}

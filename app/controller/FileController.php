<?php

namespace app\controller;

use DI\Attribute\Inject;
use support\Request;
use app\service\FileService;
use app\service\SettingService;

class FileController
{
    #[Inject]
    protected FileService $file;

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

        $result = $this->file->saveImage($file, true);

        if (!$result) {
            no(STATUS_INTERNAL_ERROR);
        }

        return ok($result);
    }
}

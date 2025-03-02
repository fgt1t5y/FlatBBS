<?php

namespace app\controller;

use DI\Attribute\Inject;
use support\Request;
use app\service\FileService;

class FileController
{
    #[Inject]
    protected FileService $file;

    public function upload(Request $request)
    {
        $request->assertLogin();

        $file = $request->file('avgfile');

        if (!$file) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        $result = $this->file->saveImage($file, true);

        if (!$result) {
            no(STATUS_INTERNAL_ERROR);
        }

        return ok($result);
    }
}

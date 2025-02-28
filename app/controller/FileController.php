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

        $result = $this->file->uploadImage($request->file(), true);

        if (!$result) {
            no(STATUS_INTERNAL_ERROR);
        }

        return ok($result);
    }
}
